const hre = require("hardhat");

async function main() {
  console.log("🚀 Starting deployment...");

  const existingVerifier = process.env.IDENTITY_VERIFIER_ADDRESS;
  let verifierAddress;

  if (existingVerifier) {
    console.log(`✅ Using existing Groth16Verifier at: ${existingVerifier}`);
    verifierAddress = existingVerifier;
  } else {
    console.log("🛠️ Deploying new Groth16Verifier...");
    const Verifier = await hre.ethers.getContractFactory("Groth16Verifier");
    const verifier = await Verifier.deploy();
    await verifier.waitForDeployment();
    verifierAddress = await verifier.getAddress();
    console.log(`✅ Deployed new Groth16Verifier at: ${verifierAddress}`);
  }

  console.log("🧩 Deploying IdentityMerkleZKP with verifier address:", verifierAddress);
  const IdentityMerkleZKP = await hre.ethers.getContractFactory("IdentityMerkleZKP");
  const identityMerkleZkp = await IdentityMerkleZKP.deploy(verifierAddress);
  await identityMerkleZkp.waitForDeployment();

  const identityZkpAddress = await identityMerkleZkp.getAddress();
  console.log(`✅ IdentityMerkleZKP deployed at: ${identityZkpAddress}`);

  console.log("\n✨ Deployment Summary ✨");
  console.log("Verifier Address: ", verifierAddress);
  console.log("IdentityMerkleZKP Address: ", identityZkpAddress);

  // Simpan hasilnya ke file JSON biar verify.js bisa baca
  const fs = require("fs");
  fs.writeFileSync(
    "./deployment.json",
    JSON.stringify({ verifierAddress, identityZkpAddress }, null, 2)
  );

  console.log("\n💾 Saved to deployment.json");
}

main().catch((error) => {
  console.error(error);
  process.exitCode = 1;
});
