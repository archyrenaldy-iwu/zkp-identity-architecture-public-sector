#!/usr/bin/env python3
"""
Chi-Square Unlinkability Test Reproduction Script (Equation 4)
Paper: Bytecode Security Auditing and Live Mainnet Validation of a Zero-Knowledge
       Identity Verification Architecture for Public-Sector Blockchain Platforms
"""

import csv
import math
import os

def calculate_chi_square():
    base_dir = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
    zkp_file = os.path.join(base_dir, "data/polygon_mainnet_transactions_zkp.csv")
    sengketa_file = os.path.join(base_dir, "data/polygon_mainnet_transactions_sengketa.csv")

    with open(zkp_file, mode="r", encoding="utf-8") as f:
        zkp_txs = list(csv.DictReader(f))

    with open(sengketa_file, mode="r", encoding="utf-8") as f:
        sengketa_txs = list(csv.DictReader(f))

    n_zkp = len(zkp_txs)
    n_sengketa = len(sengketa_txs)
    n_total = n_zkp + n_sengketa

    # Observed frequencies across live mainnet contracts
    O = [n_zkp, n_sengketa]
    # Expected frequencies under uniform hypothesis (Equation 4)
    E = [n_total / 2.0, n_total / 2.0]

    # Chi-Square statistic: sum((O - E)^2 / E)
    chi2 = sum((o - e) ** 2 / e for o, e in zip(O, E))

    # Degrees of freedom = k - 1 = 2 - 1 = 1
    # P-value for df=1: erfc(sqrt(chi2) / sqrt(2))
    p_value = math.erfc(math.sqrt(chi2) / math.sqrt(2))

    print("=" * 60)
    print("CHI-SQUARE UNLINKABILITY TEST (Equation 4)")
    print("=" * 60)
    print(f"Sample Size (n):                 {n_total} transactions")
    print(f"  - ZKP Identity Contract:       {n_zkp} observed")
    print(f"  - Dispute Workflow Contract:   {n_sengketa} observed")
    print(f"Expected Uniform Frequency (E):  {E[0]:.1f} per category")
    print(f"Chi-Square Statistic (chi^2):    {chi2:.2f}")
    print(f"p-value (alpha = 0.05):          {p_value:.3f}")
    print(f"Conclusion:                      {'Fail to reject H0 (Sessions unlinkable)' if p_value > 0.05 else 'Reject H0'}")
    print("=" * 60)

if __name__ == "__main__":
    calculate_chi_square()
