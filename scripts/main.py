#!/usr/bin/env python3
"""
Main entry for all genome analysis functions.
"""

import argparse
import sys
import time
import os
import sys
import shutil
import argparse
import subprocess
import pandas as pd
import numpy as np


## gene prediction
def genemark(i, tmp):

    if os.path.exists(tmp + "/gms2results") != True:
        subprocess.call(["mkdir", tmp + "/gms2results"])
    if os.path.exists(tmp + "/gms2results/gfffiles") != True:
        subprocess.call(["mkdir",tmp + "/gms2results/gfffiles"])
    if os.path.exists(tmp + "/gms2results/nucleotidefasta") != True:
        subprocess.call(["mkdir",tmp + "/gms2results/nucleotidefasta"])
    if os.path.exists(tmp + "/gms2results/proteinfasta") != True:
        subprocess.call(["mkdir",tmp + "/gms2results/proteinfasta"])

    gff = os.path.join(tmp + "/gms2results/gfffiles","{}.gff".format(i.split(".")[0]))
    nucleotides = os.path.join(tmp + "/gms2results/nucleotidefasta","{}.fna".format(i.split(".")[0]))
    proteins = os.path.join(tmp + "/gms2results/proteinfasta","{}.faa".format(i.split(".")[0]))
    dir = i
    subprocess.call(["../../team1tools/GenePrediction/gms2_linux_64/gms2.pl", "--seq", dir, "--genome-type", "bacteria", "--output",gff,"--format","gff","--fnn",nucleotides,"--faa",proteins])

def prodigal(i, tmp):
    if os.path.exists(tmp + "/prodigalresults") != True:
        subprocess.call(["mkdir",tmp + "/prodigalresults"])
    if os.path.exists(tmp + "/prodigalresults/nucleotide") != True:
        subprocess.call(["mkdir",tmp + "/prodigalresults/nucleotide"])
    if os.path.exists(tmp + "/prodigalresults/protein") != True:
        subprocess.call(["mkdir",tmp + "/prodigalresults/protein"])
    if os.path.exists(tmp + "/prodigalresults/gff") != True:
        subprocess.call(["mkdir",tmp + "/prodigalresults/gff"])

    protein = os.path.join(tmp + "/prodigalresults/protein","{}.faa".format(i.split(".")[0]))
    nucleotide = os.path.join(tmp + "/prodigalresults/nucleotide","{}.fna".format(i.split(".")[0]))
    gff = os.path.join(tmp + "/prodigalresults/gff","{}.gff".format(i.split(".")[0]))
    dir = i
    subprocess.call(["../../team1tools/GenePrediction/Prodigal/prodigal","-i",dir,"-a",protein,"-d",nucleotide,"-o",gff,"-f","gff"])

def bedtools_func(i, home, tmp):
    if os.path.exists(tmp + "/prodigal-genemark") != True:
        subprocess.call(['mkdir',tmp + '/prodigal-genemark'])
    if os.path.exists(tmp + "/prodigal-genemark/gfffiles") != True:
        subprocess.call(['mkdir',tmp + '/prodigal-genemark/gfffiles'])
    if os.path.exists(tmp + "/prodigal-genemark/gfffilesunion") != True:
        subprocess.call(['mkdir',tmp + '/prodigal-genemark/gfffilesunion'])
    if os.path.exists(tmp + "/prodigal-genemark/nucleotides") != True:
        subprocess.call(['mkdir',tmp + '/prodigal-genemark/nucleotides'])
    if os.path.exists(tmp + "/prodigal-genemark/aminoacids") != True:
        subprocess.call(['mkdir',tmp + '/prodigal-genemark/aminoacids'])

    prodigal_gff = os.path.join(tmp + '/prodigalresults','gff','{}.gff'.format(i.split(".")[0]))
    #gets gff files from prodigal
    genemark_gff = os.path.join(tmp + '/gms2results','gfffiles','{}.gff'.format(i.split(".")[0]))
    #gets gff files from genemark
    intersect1 = os.path.join(tmp + '/prodigal-genemark/gfffiles','{}intersect1.gff'.format(i.split(".")[0]))

    intersect2 = os.path.join(tmp + '/prodigal-genemark/gfffiles','{}intersect2.gff'.format(i.split(".")[0]))
    #gets intersect from genemark and prodigal
    common = os.path.join(tmp + '/prodigal-genemark/gfffiles','{}common.gff'.format(i.split(".")[0]))

    #gets common from genemark and prodigal
    union = os.path.join(tmp + '/prodigal-genemark/gfffilesunion','{}union.gff'.format(i.split(".")[0]))
    #gets union
    bedtools_intersect1 = ['../../team1tools/GenePrediction/bedtools2/bin/bedtools intersect -f 1.0 -r -wa -v -a {} -b {} > {}'.format(prodigal_gff,genemark_gff,intersect1)]

    bedtools_intersect2 = ['../../team1tools/GenePrediction/bedtools2/bin/bedtools intersect -f 1.0 -r -wa -v -b {} -a {} > {}'.format(prodigal_gff,genemark_gff,intersect2)]
    #command for intersect
    bedtools_common = ['../../team1tools/GenePrediction/bedtools2/bin/bedtools intersect -f 1.0  -r -a {} -b {} > {}'.format(prodigal_gff,genemark_gff,common)]
    #command for common

    subprocess.call(bedtools_intersect1,shell=True)
    subprocess.call(bedtools_intersect2,shell=True)
    subprocess.call(bedtools_common,shell=True)

    cat = ['cat {0} {1} {2} > {3}'.format(intersect1,intersect2,common,union)]
    #concatenates to get union
    subprocess.call(cat,shell=True)
    dir = i
    createfastaindex = ['../../team1tools/GenePrediction/samtools-1.9/bin/samtools','faidx',dir]
    #creates fasta index
    dnatoaapy = os.path.join(home,"nucltoprotein.py")
    subprocess.call(createfastaindex)
    nucleotides = os.path.join(home,"prodigal-genemark/nucleotides","{}.fna".format(i.split(".")[0]))
    fastasequences = ['../../team1tools/GenePrediction/bedtools2/bin/bedtools','getfasta','-fo',nucleotides,'-fi',dir,'-bed',union]
    amino = os.path.join(home,"prodigal-genemark/aminoacids","{}.faa".format(i.split(".")[0]))
    subprocess.call(fastasequences)

    #subprocess.call(['python3',dnatoaapy,nucleotides,amino])
    subprocess.call(['rm','-f','{}.fai'.format(dir)])

def barrnap(i):
    if os.path.exists("./barrnap_results") != True:
        subprocess.call(['mkdir','barrnap_results'])
    if os.path.exists("./barrnap_results/gfffiles") != True:
        subprocess.call(['mkdir','barrnap_results/gfffiles'])
    if os.path.exists("./barrnap_results/nucleotides") != True:
        subprocess.call(['mkdir','barrnap_results/nucleotides'])


    gff = os.path.join("barrnap_results/gfffiles","barnap_{}.gff".format(i.split(".")[0]))
    nucleotides = os.path.join("barrnap_results/nucleotides","barrnap_{}.fna".format(i.split(".")[0]))
    dir = i
    subprocess.call(['barrnap/bin/barrnap --outseq {} < {} > {}'.format(nucleotides,dir,gff)],shell=True)

def aragorn(i):
    if os.path.exists("./aragorn_results") != True:
        subprocess.call(['mkdir','aragorn_results'])
    if os.path.exists("./aragorn_results/gfffiles") != True:
        subprocess.call(['mkdir','aragorn_results/gfffiles'])
    if os.path.exists("./aragorn_results/nucleotides") != True:
        subprocess.call(['mkdir','aragorn_results/nucleotides'])

    gff = os.path.join("aragorn_results/gfffiles","aragorn_{}.gff".format(i.split(".")[0]))
    nucleotides = os.path.join("aragorn_results/nucleotides","aragorn_{}.fna".format(i.split(".")[0]))
    tRNAtxt = os.path.join("aragorn_results","{}.txt".format(i.split(".")[0]))
    dir = i

    subprocess.call(["aragorn1.2.38/aragorn","-t","-m","-gc1","-w",dir,"-fo","-o",nucleotides])
    subprocess.call(["aragorn1.2.38/aragorn","-t","-m","-gc1","-w",dir,"-o",tRNAtxt])
    subprocess.call(["/usr/bin/perl","cnv_aragorn2gff.pl","-i",dir,"-o",tRNAgff, "-gff-ver=2"])

def join(a,b, tmp):
    subprocess.call(['mkdir',tmp + '/arabarr'])

    for i,j in zip(sorted(os.listdir(a)),sorted(os.listdir(b))):
        subprocess.call('cat aragorn_results/nucleotides/{} barrnap_results/nucleotides/{} > arabarr/arabarr_{}.fna'.format(i,j,i.split("_")[1]),shell=True)


## functional_annotation
def vfdbBlast(inputFile):

    subprocess.call(["team1tools/FunctionalAnnotation/ncbi-blast-2.9.0+/bin/blastn", # todo: fix path
                    "-db", "team1tools/FunctionalAnnotation/vfDB",
                    "-query", inputFile,
                    "-num_threads", "4",
                    "-evalue" ,"1e-10",
                    "-outfmt", "'6 stitle qseqid pident qcovs qstart qend qseq evalue bitscore'",
                    "-best_hit_score_edge", "0.1",
                    "-best_hit_overhang", "0.1",
                    "-max_target_seqs", "1",
                    "-out", "vfdb_temp"])

def vfdb_to_gff(inputFile, outputFile):

    output_name = outputFile + ".gff"
    output = open(output_name, "w+")

    with open(inputFile,"r",encoding='latin-1') as fh:
         for l in fh:
             l=l.strip("\n").split("\t")
             notes=l[0]
             seqid=l[1]
             start=l[5]
             end=l[8]
             output.write("{}\tVFDB-BLAST\tBacterial Virulent genes\t{}\t{}\t.\t.\t.\t{}\n".format(seqid,start,end,notes))
    output.close()

def vfdb(inputFile, outputFile):

    vfdbBlast(inputFile)

    vfdb_to_gff("vfdb_temp", outputFile)

    subprocess.call(["rm", "vfdb_temp"])


def CARD_rgi(inputFile):
    card = "/team1tools/FunctionalAnnotation/rgi-4.2.2/card.json"
    model = "/team1tools/FunctionalAnnotation/rgi-4.2.2/protein_fasta_protein_homolog_model.fasta"  # todo: fix path

    subprocess.run(["rgi", "load",
                    "-i", card,
                    "--card_annotation", model,
                    "--local"])

    subprocess.run(["rgi", "main",
                    "-i", inputFile,
                    "-o", "card_temp",
                    "--input_type", "protein",
                    "--local"])


def rgi_to_gff(inputFile, outputFile):
    file = open(inputFile, 'r', encoding='latin-1')
    next(file)

    output_name = outputFile + ".gff"
    output = open(output_name, "w")
    output.write("##gff-version 3\n")

    for line in file:
        line = re.sub('\s+', '\t', line).strip().split("\t")
        # print(line)
        seqid = line[0]
        start = line[2]
        end = line[4]
        notes = line[12:-5]
        notes = ';'.join(notes)
        output.write("{}\tRGI-CARD\tAntibiotic resistant genes\t{}\t{}\t.\t.\t.\t{}\n".format(seqid, start, end, notes))

    file.close()
    output.close()


def CARD(inputFile, outputFile):
    cardtemp = "card_temp.txt"
    cardtemp2 = "card_temp.json"

    CARD_rgi(inputFile)

    rgi_to_gff(cardtemp, outputFile)

    subprocess.call(["rm", cardtemp])
    subprocess.call(["rm", cardtemp2])

## gene assembly
def assemble_genomes(_tmp_dir,  tmp_next, results):
    """
    run different assemblers and choose the best result
    :param _tmp_dir: tmp directory
    :param _assemblers: assemblers given by user
    :return: None
    """
    # spades
    run_spades(_tmp_dir)
    # quast
    subprocess.call(["../../team1tools/GenomeAssembly/quast-5.0.2/quast.py",  _tmp_dir + "/spades/scaffolds.fasta", "-o", _tmp_dir + "/quast"])
    quast_result = "%s/quast/report.tsv" % _tmp_dir
    try:
       result = pd.read_table(quast_result, index_col=0)
    except FileNotFoundError:
       print("quast report does not exist!")
       print("Abort")
       return
    result.loc["score"] = np.log(result.loc["Total length (>= 0 bp)"] * result.loc["N50"] / result.loc["# contigs"])
    result.to_csv(results + "/quast.csv", header=True, index=True)
    print("-" * 20 + "quast finished" + "-" * 20)

    subprocess.call(["mv", _tmp_dir + "/spades/scaffolds.fasta", tmp_next + "/input.fasta"])


def run_spades(_tmp_dir):
    """
    run spades on trimmed file
    :param _tmp_dir: tmp directory
    :return: output contigs file name
    """
    spades_cmd =["../../team1tools/GenomeAssembly/SPAdes-3.11.1-Linux/bin/spades.py", "--phred-offset", "33", "-k", "99", "-1", "{0}/trimmed_1P.fastq".format(_tmp_dir), "-2", "{0}/trimmed_2P.fastq".format(_tmp_dir), "-o", "{0}/spades".format(_tmp_dir)]
    if "trimmed_U.fastq" in os.listdir(_tmp_dir):
        spades_cmd.extend(["-s", "{0}/trimmed_U.fastq".format(_tmp_dir)])
    subprocess.call(spades_cmd)


def run_fake_trim(trimmomatic_jar, _input_files, _tmp_dir):
    """
    generate fastq file for assembler, do not change file content
    :param trimmomatic_jar: trimmomatic jar file
    :param _input_files: input fastq file
    :param _tmp_dir: tmp directory
    :return: None
    """
    print("running fake trim")
    command = ["java", "-jar", trimmomatic_jar, "PE", _input_files[0], _input_files[1], "-baseout", _tmp_dir + "/trimmed.fastq", "MINLEN:100"]
    subprocess.call(command)
    subprocess.call(["rm", "-rf", "{0}/trimmed_*U.fastq".format(_tmp_dir)])


def run_fastqc(_input_file, _tmp_dir):
    """
    run fastqc for each file
    :param _input_file: input fastq file
    :param _tmp_dir: tmp directory
    :return: None
    """
    subprocess.call(["../../team1tools/GenomeAssembly/FastQC/fastqc", "--extract", "-o", _tmp_dir, _input_file], stderr=subprocess.DEVNULL)


def check_crop(_tmp_dir, _fastqc_dirs):
    """
    check if hard crop is needed
    :param _tmp_dir: tmp directory
    :param _fastqc_dirs: location of fastqc report
    :return: [head_crop, crop]
    """
    print("checking crop")
    crops = [0, 0]
    for i, dir in enumerate(_fastqc_dirs):
        qualities = []
        positions = []
        data_file_name = "%s/%s/fastqc_data.txt" % (_tmp_dir, dir)
        with open(data_file_name, "r") as data:
            data_recorded = False
            for line in data:
                if line.startswith("#"):
                    continue
                elif "Per base sequence quality" in line:
                    data_recorded = True
                elif data_recorded and line.startswith(">>"):
                    break
                elif data_recorded:
                    position, quality, *tmp = line.split()
                    positions.append(position)
                    qualities.append(float(quality))
                continue
        i = 0
        while qualities[i] < 20:
            i += 1
        crops[0] = max(int(positions[i].split("-")[-1]), crops[0])
        i = len(qualities) - 1
        while qualities[i] < 20:
            i -= 1
        crops[1] = min(int(positions[i].split("-")[0]), crops[1])
        print(crops)
    return crops


def run_trim(trimmomatic_jar, _input_files, _tmp_dir, window, threshold, headcrop, crop):
    """
    run trimmomatic on fastq file
    :param trimmomatic_jar: trimmomatic jar file
    :param _input_files: input fastq file
    :param _tmp_dir: tmp directory
    :param window: windown size of sliding window
    :param threshold: threshold in each window
    :param headcrop: hard crop from beginning
    :param crop: hard crop from end
    :return: drop rate of this trimming
    """
    command = ["java", "-jar", trimmomatic_jar, "PE", _input_files[0], _input_files[1], "-baseout", _tmp_dir + "/trimmed.fastq"]
    command.append("HEADCROP:%d" % headcrop)
    command.append("CROP:%d" % crop)
    command.extend(["SLIDINGWINDOW:%d:%d" % (window, threshold), "MINLEN:100"])
    #print("trim cmd", command)
    proc = subprocess.Popen(command, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
    proc.wait()
    out, trim_summary = proc.communicate()
    if trim_summary:
        trim_summary = trim_summary.decode("utf-8")
        drop_rate = trim_summary.split("\n")[-3].split()[-1][1:-2]
        with open("{0}/trimmed_U.fastq".format(_tmp_dir), "w") as f:
            subprocess.call(["cat", "{0}/trimmed_1U.fastq".format(_tmp_dir), "{0}/trimmed_2U.fastq".format(_tmp_dir)], stdout=f)
        return float(drop_rate)
    return 0


def trim_files(input_files, tmp_dir, trimmomatic_jar):
    """
    Trim input files.
    Trim is done on those not passing fastqc per seq quality. sliding window is used, and window increases each step until drop rate is less that 33%.
    For those passes fastqc, a minlen:100 trimming is done for format consistency.
    :param input_files: input fastq file
    :param tmp_dir: tmp directory
    :param trimmomatic_jar: trimmomatic jar file
    :return: None
    """

    window_steps = [4, 8, 12, 20, 35, 50, 70]
    fastqc_dirs = ["", ""]

    # get fastqc for raw input
    for i, file in enumerate(input_files):
        fastqc_dirs[i] = os.path.split(file)[-1].rstrip(".fastq") + "_fastqc"
        run_fastqc(file, tmp_dir)
        # os.remove("%s/%s.html" % (tmp_dir, fastqc_dirs[i]))
        # os.remove("%s/%s.zip" % (tmp_dir, fastqc_dirs[i]))
    print("-" * 20 + "fastqc finished" + "-" * 20)

    with open("%s/%s/summary.txt" % (tmp_dir, fastqc_dirs[0]), "r") as f1, open("%s/%s/summary.txt" % (tmp_dir, fastqc_dirs[1]), "r") as f2:
        line1 = f1.readline()
        line1 = f1.readline()
        line2 = f2.readline()
        line2 = f2.readline()
        try:
            if line1.split()[0] == "PASS" and line2.split()[0] == "PASS":
                run_fake_trim(trimmomatic_jar, input_files, tmp_dir)
                length = "250"
                with open(tmp_dir + "/trimmed_1P.fastq", "r") as f:
                    f.readline()
                    length = len(f.readline().strip())
                return str(length)
        except IndexError:
            sys.stderr.write("read summary indexerror at %s" % input_files[0] + "\n")
            return

    trim_condition = [window_steps[0], 20, *check_crop(tmp_dir, fastqc_dirs)]
    while trim_condition is not False:
        subprocess.call(["rm", "-rf", "{0}/trimmed_*.fastq".format(tmp_dir)])
        drop_rate = run_trim(trimmomatic_jar, input_files, tmp_dir, *trim_condition)
        # print("-" * 10, drop_rate)
        if drop_rate > 33 and trim_condition[0] != window_steps[-1]:
            trim_condition[0] = window_steps[window_steps.index(trim_condition[0]) + 1]
        elif trim_condition[0] == window_steps[-1]:
            run_fake_trim(trimmomatic_jar, input_files, tmp_dir)
        else:
            trim_condition = False
    print("-" * 20 + "trim finished" + "-" * 20)
    length = "250"
    print("%s/%s/fastqc_data.txt" % (tmp_dir, fastqc_dirs[0]))
    with open("%s/%s/fastqc_data.txt" % (tmp_dir, fastqc_dirs[0]), "r") as f:
        for line in f:
            if line.startswith("Sequence length"):
                #print(line)
                length = line.strip().split()[-1]
                break
    return length


## main
def main(args):
    results = "../storage/app/public/results"
    if not os.path.exists(results):
        os.mkdir(results)
    a_tmp = "../storage/app/public/assemble"
    if not os.path.exists(a_tmp):
        os.mkdir(a_tmp)
    b_tmp = "../storage/app/public/prediction"
    if not os.path.exists(b_tmp):
        os.mkdir(b_tmp)

    if args.a:
        trim_files(args.infastq, a_tmp, "../../team1tools/GenomeAssembly/Trimmomatic-0.36/trimmomatic-0.36.jar")
        assemble_genomes(a_tmp, b_tmp, results)  # todo: wait for larger file to test
        assemble_result = b_tmp + "/input.fasta"
        shutil.rmtree(a_tmp)
    else:
        assemble_result = args.infasta
    if args.b:
        home = os.getcwd()
        if args.p:
            prodigal(assemble_result, b_tmp)
        if args.g:
            genemark(assemble_result, b_tmp)
        # Runs bedtools if both genemark and prodigal are selected
        if (args.p and args.g):
            bedtools_func(assemble_result, home, b_tmp)
        # Default mode to run both prodigal and genemark with bedtools_func
        if not args.p:
            if not args.g:
                prodigal(assemble_result, b_tmp)
                genemark(assemble_result, b_tmp)
                bedtools_func(assemble_result, home, b_tmp)

        # Runs aragorn and barrnap if selected
        if args.nc:
            aragorn(assemble_result)
            barrnap(assemble_result)
            join('aragorn_results/nucleotides', 'barrnap_results/nucleotides', b_tmp)
        if args.ncs:
            aragorn(assemble_result)
            barrnap(assemble_result)
        predict_result = ""
        shutil.rmtree(b_tmp)
    else:
        predict_result = args.infile

    if args.c:
        pass
    else:
        annotation_result = args.infile
    if args.d:
        pass
    shutil.rmtree(a_tmp)

    print("main.py finished!")
    # parse arguments and call proper functions


if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    # I/O parameters
    parser.add_argument('--infastq', metavar=("file1", "file2"), nargs=2, help='input fastq')
    parser.add_argument('--infasta', nargs=1, help='input fasta')
    parser.add_argument('--outfile', required=True, help='output file name')
    parser.add_argument('-a', action="store_true", help='do step 1')
    parser.add_argument('-b', action="store_true", help='do step 2')
    parser.add_argument('-c', action="store_true", help='do step 3')
    parser.add_argument('-d', action="store_true", help='do step 4')

    # parameters for genome assembly
    # todo: hard code trimmomatic, tmp folder
    # parameters for gene prediction
    parser.add_argument('-p', help='Run Prodigal for ab-initio protein coding gene predictor.', required=False, action='store_true')
    parser.add_argument('-g', help='Run GeneMarkS-2 for ab-initio protein coding gene predictor.', required=False, action='store_true')
    parser.add_argument('-nc', help='Runs Aragorn and Barrnap for non-coding RNA prediction.', required=False, action='store_true')
    parser.add_argument('-ncs', help='Runs Aragorn and Barrnap independently.', required=False, action='store_true')
    # parameters for functional annotation

    # parameters for comparative analysis

    # other parameters
    parser.add_argument('--email', default=None, help='email address(if given) used to send notification')

    args = parser.parse_args()
    main(args)
