const hre = require("hardhat");
const { ethers } = require("ethers");

async function main() {
  // Ambil provider dari konfigurasi Hardhat
  const provider = new hre.ethers.JsonRpcProvider(hre.network.config.url);
  const wallet = new hre.ethers.Wallet(process.env.PRIVATE_KEY, provider);

  const balance = await provider.getBalance(wallet.address);

  console.log("Deployer:", wallet.address);
  console.log("💰 Balance:", ethers.formatEther(balance), "MATIC");
}

main().catch((error) => {
  console.error(error);
  process.exitCode = 1;
});
