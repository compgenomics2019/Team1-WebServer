#!/usr/bin/env python3
import argparse
import os
import subprocess
import sys
import pandas as pd
import createDiffMatrix

def kSNP3(inFile, outDir):
    ## Automatically create in file, makefasta, kchooser for user and run kSNP3
    input_path = os.path.abspath(inFile)
    file_head = input_path.split('/')[::-1]
    # Copy .fasta contigs file (from Genome Assembly output) into directory w/ database contigs for MakeKSNPinfile command
    copyFasta = "cp /projects/VirtualHost/predicta/web_src/storage/app/uploads/assemble/{}_genome.fasta /projects/VirtualHost/predicta/web_src/storage/app/uploads/comparative/contigs/".format(file_head)
    subprocess.call(copyFasta, shell=True)
    # Creates input file, which is just a list of all of the genome file paths
    MakeKSNPin = "MakeKSNP3infile {} {}_infile A".format(input_path, file_head)
    subprocess.call(MakeKSNPin, shell=True)
    # Concatenates all genomic files for a fasta to optimize k-mer length
    makeFASTA = "MakeFasta {}_infile {}.fasta".format(file_head, file_head)
    subprocess.call(makeFASTA, shell=True)
    # Optimize k-mer length
    kCHOOSE_r = "Kchooser {}.fasta".format(file_head)
    subprocess.call(kCHOOSE_r, shell=True)
    # Parse Kchooser.report for optimal k-value
    dir_kc = os.getcwd()
    file_hand = open('dir_kc/Kchooser.report', 'r')
    k_val = 0
    for i in file_hand:
        if i.startswith('When'):
            k_val = int(i.split()[3])
    file_hand.close()
    # Run kSNP3 given input file and optimal k-mer length
    k_script = "kSNP3 -in {}_infile -outdir {} -k {} -ML | tee {}_log".format(file_head, fileOut, k_val, file_head)
    subprocess.call(k_script, shell=True)
    removeFasta = "rm /projects/VirtualHost/predicta/web_src/storage/app/uploads/comparative/contigs/{}_genome.fasta".format(file_head)
    subprocess.call(removeFasta, shell=True)
	
def MASH(inFile):
    ## Compute MASH distance while querying to find potentially related strains
    input_path = os.path.abspath(inFile)
    for file in os.listdir(input_path):
        mash_cmd = "mash dist refseq.genomes.k21s1000.msh {} > distances_{}.tab".format(file, file.split('.')[0])
	    subprocess.call(mash_cmd, shell=True)
        mash_out = "sort -gk3 distances_{}.tab | head -n1 >> strains_file.txt"/format(file.split('.')[0])
        subprocess.call(mash_out, shell=True)

def calDifference(inFile):
    """ before calculate difference for output of cgMLST, the last two columns need to be cut
    the output will be on the inFile """
    inFile_dropST=os.path.abspath(inFile) + "_dropST.csv" 
    dropColumns(inFile,inFile_dropST)
    outFile=os.path.join("/".join(os.path.abspath(inFile_dropST).split("/")[:-1]),"diffMatrix.csv")
    
    #after dropping ST columns, now can begin calculating the difference
    createDiffMatrix.main(inFile_dropST,outFile)
def dropColumns(inFile,outFile):
    file=pd.read_csv(inFile,sep='\t')
    file=file.drop(columns=['ST','clonal_complex']) ### drop columns
    file.to_csv(outFile,sep=',',index=False)     ### write into csv


'''
def main():
    parser = argparse.ArgumentParser()
    parser.add_argument("-m", "--mlst",action="store_true", help="running mentalist")
    parser.add_argument("-diff",action="store_true", help="calculate differences from cgMLST results")
    parser.add_argument("-i", "--inputFile",help="the path of input file")
    parser.add_argument("-o", "--outFile" ,help="path of output file/directory") 
    parser.add_argument("-db", "--database", help="path of database for cgMLST ") 
    parser.add_argument("-k", "--ksnp", action="store_true", help="running kSNP3")
    parser.add_argument("-mash", action="store_true", help="Run MASH distance on genomes")
    args = parser.parse_args()
    if args.mlst:
        if args.database == None:
            raise SystemExit("missing database to run mentalist. Exit")
        if args.inputFile==None:
            raise SystemExit("missing input sample file to run mentalist. Exit")
        if args.outFile==None:
            raise SystemExit("missing output name to run mentalist. Exit")
        else:
            cgMLST_call(args.inputFile,args.outFile,args.database)
    if args.diff:
        if args.inputFile==None:
            raise SystemExit("missing the result file of cgMLST calling to calculate the differences. Exit")
        calDifference(args.inputFile)
    if args.ksnp:
        if args.inFile==None:
            raise SystemExit("Please specify an input directory containing your genomes of analysis")
	if args.outFile==None:
	    raise SystemExit("Please specify an output directory")
	kSNP3(args.inFile, args.outFile)
    if args.mash:
        if args.inFile==None:
            raise SystemExit("Please specify an input directory containing your genomes of analysis")
	MASH(args.inFile)
'''

if __name__ == "__main__":
    main()