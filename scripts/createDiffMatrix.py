import csv
import numpy as np
import itertools
import pandas as pd
import sys
import subprocess
import os

if __name__=="__main__":
    _, path, outfile = sys.argv
    files = os.listdir(path)
    mat = np.zeros((50, 50))
    for i, j in itertools.combinations(files, 2):
        idi = files.index(i)
        idj = files.index(j)
        f1 = os.path.join(path, i)
        f2 = os.path.join(path, j)
        mash_cmd = subprocess.Popen(["../../team1tools/ComparativeGenomics/mash-Linux64-v2.0/mash", "dist", f1, f2], stdout=subprocess.PIPE)
        mash_out, _ = mash_cmd.communicate()
        print(mash_out)
        mat[i][j] = float(mash_out.split()[2])
        mat[j][i] = float(mash_out.split()[2])
    df = pd.DataFrame(mat)
    print(df.shape)
    df.to_csv("50_distances.csv", header=False, index=False)
