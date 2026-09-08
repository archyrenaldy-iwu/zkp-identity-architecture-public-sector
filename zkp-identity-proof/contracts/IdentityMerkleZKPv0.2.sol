// SPDX-License-Identifier: MIT
pragma solidity ^0.8.20;

import "./IdentityMerkleVerifier.sol"; // file yang kamu kirim (contract Groth16Verifier)

contract IdentityMerkleZKP {
    Groth16Verifier private verifier;

    // Merkle root dan mapping leaves yang di-approve
    bytes32 public currentMerkleRoot;
    mapping(bytes32 => bool) public approvedIdentities;
    mapping(bytes32 => uint256) public identityApprovalBlock;
    bytes32[] public identityLeaves;
    address public admin;
    uint256 public totalApprovedIdentities;

    // Events
    event MerkleRootUpdated(bytes32 indexed oldRoot, bytes32 indexed newRoot);
    event IdentityApproved(bytes32 indexed leaf);
    event IdentityRevoked(bytes32 indexed leaf);
    event IdentityVerified(address indexed verifierAddress, bytes32 indexed leaf);
    event AdminChanged(address indexed oldAdmin, address indexed newAdmin);

    modifier onlyAdmin() {
        require(msg.sender == admin, "Only admin");
        _;
    }

    constructor(address _verifier) {
        require(_verifier != address(0), "Invalid verifier");
        verifier = Groth16Verifier(_verifier);
        admin = msg.sender;
    }

    /**
     * Update Merkle root dan set daftar leaf yang di-approve.
     * Sesuai call dari backend: updateMerkleRootWithIdentities(rootBytes32, leavesBytes32[])
     */
    function updateMerkleRootWithIdentities(
        bytes32 newRoot,
        bytes32[] calldata leaves
    ) external onlyAdmin {
        require(newRoot != bytes32(0), "Invalid root");
        require(leaves.length > 0, "Empty leaves");

        bytes32 oldRoot = currentMerkleRoot;
        currentMerkleRoot = newRoot;

        // Reset previous approval mapping (keputusan: non-permanent, replace list)
        for (uint256 i = 0; i < identityLeaves.length; i++) {
            approvedIdentities[identityLeaves[i]] = false;
            identityApprovalBlock[identityLeaves[i]] = 0;
        }

        delete identityLeaves;
        totalApprovedIdentities = 0;

        for (uint256 i = 0; i < leaves.length; i++) {
            bytes32 leaf = leaves[i];
            require(leaf != bytes32(0), "Invalid leaf");
            if (!approvedIdentities[leaf]) {
                approvedIdentities[leaf] = true;
                identityApprovalBlock[leaf] = block.number;
                identityLeaves.push(leaf);
                totalApprovedIdentities++;
                emit IdentityApproved(leaf);
            }
        }

        emit MerkleRootUpdated(oldRoot, newRoot);
    }

    /**
     * Hanya update root (tanpa mengganti approved list)
     */
    function updateMerkleRoot(bytes32 newRoot) external onlyAdmin {
        require(newRoot != bytes32(0), "Invalid root");
        require(newRoot != currentMerkleRoot, "Root same");
        bytes32 oldRoot = currentMerkleRoot;
        currentMerkleRoot = newRoot;
        emit MerkleRootUpdated(oldRoot, newRoot);
    }

    /**
     * Check approval status
     */
    function isIdentityApproved(bytes32 leaf) external view returns (bool) {
        return approvedIdentities[leaf];
    }

    function viewLeaf(uint256 idx) external view returns (bytes32) {
        require(idx < identityLeaves.length, "Invalid index");
        return identityLeaves[idx];
    }

    function totalLeaves() external view returns (uint256) {
        return identityLeaves.length;
    }

    /**
     * verifyIdentity
     * - Dipanggil oleh backend
     * - dipanggil dulu via callStatic(...) untuk simulasi
     * - kemudian backend memanggil tx verifyIdentity(...) (sama fungsi)
     *
     * Signature menyesuaikan yang dipakai di JS: (uint[2], uint[2][2], uint[2], bytes32 leaf)
     *
     * NOTE: verifier.verifyProof expects publicInputs length = 1 (merkleRoot).
     */
    function verifyIdentity(
        uint256[2] calldata a,
        uint256[2][2] calldata b,
        uint256[2] calldata c,
        bytes32 leaf
    ) public returns (bool) {
        require(currentMerkleRoot != bytes32(0), "Merkle root not set");
        require(approvedIdentities[leaf], "Leaf not approved");

        // Build public input array (only root)
        uint256[1] memory input;
        input[0] = uint256(currentMerkleRoot);

        // verifyProof signature: verifyProof(uint[2] calldata, uint[2][2] calldata, uint[2] calldata, uint[1] calldata)
        bool ok = verifier.verifyProof(a, b, c, input);
        require(ok, "Invalid ZK proof");

        emit IdentityVerified(msg.sender, leaf);
        return true;
    }

    /**
     * approveIdentity / revokeIdentity individual helpers (optional)
     */
    function approveIdentity(bytes32 leaf) external onlyAdmin {
        require(leaf != bytes32(0), "Invalid leaf");
        if (!approvedIdentities[leaf]) {
            approvedIdentities[leaf] = true;
            identityApprovalBlock[leaf] = block.number;
            identityLeaves.push(leaf);
            totalApprovedIdentities++;
            emit IdentityApproved(leaf);
        }
    }

    function revokeIdentity(bytes32 leaf) external onlyAdmin {
        require(approvedIdentities[leaf], "Not approved");
        approvedIdentities[leaf] = false;
        // note: identityLeaves array not compacted to save gas; viewLeaf may still return revoked leafs
        totalApprovedIdentities--;
        emit IdentityRevoked(leaf);
    }

    function transferAdmin(address newAdmin) external onlyAdmin {
        require(newAdmin != address(0), "Invalid admin");
        address old = admin;
        admin = newAdmin;
        emit AdminChanged(old, newAdmin);
    }
}
