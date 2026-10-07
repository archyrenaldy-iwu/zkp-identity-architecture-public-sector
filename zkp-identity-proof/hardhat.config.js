require("dotenv").config();
require("@nomicfoundation/hardhat-toolbox");
require("@nomicfoundation/hardhat-verify");
// import "@nomicfoundation/hardhat-verify";

const {
  PRIVATE_KEY,
  POLYGON_AMOY_RPC,
  POLYGON_MAINNET_RPC,
  POLYGONSCAN_API_KEY,
} = process.env;

const networks = {};

if (POLYGON_AMOY_RPC && PRIVATE_KEY) {
  networks.polygonAmoy = {
    url: POLYGON_AMOY_RPC,
    accounts: [PRIVATE_KEY],
  };
}

if (POLYGON_MAINNET_RPC && PRIVATE_KEY) {
  networks.polygonMainnet = {
    url: POLYGON_MAINNET_RPC,
    accounts: [PRIVATE_KEY],
  };
}

module.exports = {
  solidity: "0.8.20",
  networks,
  ...(POLYGONSCAN_API_KEY
    ? { etherscan: { apiKey: POLYGONSCAN_API_KEY } }
    : {}),
};
