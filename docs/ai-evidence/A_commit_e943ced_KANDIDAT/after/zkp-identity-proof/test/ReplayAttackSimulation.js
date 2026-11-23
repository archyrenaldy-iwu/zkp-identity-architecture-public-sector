const { expect } = require("chai");
const { ethers } = require("hardhat");

describe("Replay-Attack Simulation (Figure 5)", function () {
  let mockVerifier, identityMerkleZkp;
  let admin, legitimateUser, attacker;

  beforeEach(async function () {
    [admin, legitimateUser, attacker] = await ethers.getSigners();

    // Deploy MockGroth16Verifier
    const MockVerifierFactory = await ethers.getContractFactory("MockGroth16Verifier");
    mockVerifier = await MockVerifierFactory.connect(admin).deploy();
    await mockVerifier.waitForDeployment();

    const IdentityMerkleZKPFactory = await ethers.getContractFactory(
      "contracts/IdentityMerkleZKP.sol:IdentityMerkleZKP"
    );
    identityMerkleZkp = await IdentityMerkleZKPFactory.connect(admin).deploy(
      await mockVerifier.getAddress()
    );
    await identityMerkleZkp.waitForDeployment();

    // Set sample Merkle root
    const sampleMerkleRoot = "0x" + "1".repeat(64);
    await identityMerkleZkp.connect(admin).updateMerkleRoot(sampleMerkleRoot);
  });

  it("should simulate replay attacks: 50 duplicate proofs submitted, 50/50 (100%) blocked", async function () {
    const a = ["1", "2"];
    const b = [
      ["3", "4"],
      ["5", "6"],
    ];
    const c = ["7", "8"];
    const identityHash = "0x" + "2".repeat(64);

    // 1. Initial verification by legitimate user must succeed
    const tx = await identityMerkleZkp
      .connect(legitimateUser)
      .verifyIdentity(a, b, c, identityHash);
    const receipt = await tx.wait();
    expect(receipt.status).to.equal(1);

    // 2. Replay simulation: submit 50 duplicate proofs
    const totalReplayAttempts = 50;
    let blockedCount = 0;

    for (let i = 1; i <= totalReplayAttempts; i++) {
      await expect(
        identityMerkleZkp
          .connect(attacker)
          .verifyIdentity(a, b, c, identityHash)
      ).to.be.revertedWith("Replay attack detected: proof already spent");
      blockedCount++;
    }

    expect(blockedCount).to.equal(50);
    console.log(`\n    ==================================================`);
    console.log(`    [Figure 5 Replication Result]`);
    console.log(`    Total Replay Attempts: ${totalReplayAttempts}`);
    console.log(`    Total Blocked:         ${blockedCount} (100.0%)`);
    console.log(`    State-Lock Status:     DETERMINISTIC NULLIFIER ACTIVE`);
    console.log(`    ==================================================\n`);
  });
});
