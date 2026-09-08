const hre = require("hardhat");
const fs = require("fs");

async function main() {
  if (!fs.existsSync("./deployment.json")) {
    throw new Error("❌ deployment.json not found. Run deploy.js first!");
  }

  const { verifierAddress, identityZkpAddress } = JSON.parse(
    fs.readFileSync("./deployment.json", "utf8")
  );

  console.log("🧾 Starting contract verification...");
  console.log("Verifier: ", verifierAddress);
  console.log("IdentityMerkleZKP: ", identityZkpAddress);

  // Verifikasi kontrak verifier (opsional)
  if (process.argv.includes("--verify-verifier")) {
    console.log("🔍 Verifying Groth16Verifier...");
    try {
      await hre.run("verify:verify", {
        address: verifierAddress,
        contract: "contracts/IdentityMerkleVerifier.sol:Groth16Verifier",
      });
      console.log("✅ Verifier verified successfully");
    } catch (err) {
      console.warn("⚠️ Verifier verification skipped or already verified:", err.message);
    }
  }

  // Verifikasi kontrak utama
  console.log("🔍 Verifying IdentityMerkleZKP...");
  try {
    await hre.run("verify:verify", {
      address: identityZkpAddress,
      constructorArguments: [verifierAddress],
    });
    console.log("✅ IdentityMerkleZKP verified successfully");
  } catch (err) {
    console.warn("⚠️ IdentityMerkleZKP verification skipped or already verified:", err.message);
  }

  console.log("\n🎉 Verification process complete!");
}

main().catch((error) => {
  console.error(error);
  process.exitCode = 1;
});
