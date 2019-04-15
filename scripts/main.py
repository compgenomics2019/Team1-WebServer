#!/usr/bin/env python3
"""
Main entry for all genome analysis functions.
"""

import argparse
import sys
import time
import os

def main(args):
    time.sleep(2)
    print("this is output for main.py")
    # parse arguments and call proper functions

if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    # I/O parameters
    parser.add_argument('--infile', help='input file name')
    parser.add_argument('--outfile', help='output file name')
    # parameters for genome assembly

    # parameters for gene prediction

    # parameters for functional annotation

    # parameters for comparative analysis

    # other parameters
    parser.add_argument('--email', default=None, help='email address(if given) used to send notification')

    args = parser.parse_args()
    main(args)