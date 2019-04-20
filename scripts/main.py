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
import re


## gene prediction
def genemark(name, input, tmp):
    if os.path.exists(tmp + "/gms2results") != True:
        subprocess.call(["mkdir", tmp + "/gms2results"])
    if os.path.exists(tmp + "/gms2results/gfffiles") != True:
        subprocess.call(["mkdir", tmp + "/gms2results/gfffiles"])
    if os.path.exists(tmp + "/gms2results/nucleotidefasta") != True:
        subprocess.call(["mkdir", tmp + "/gms2results/nucleotidefasta"])
    if os.path.exists(tmp + "/gms2results/proteinfasta") != True:
        subprocess.call(["mkdir", tmp + "/gms2results/proteinfasta"])

    gff = os.path.join(tmp + "/gms2results/gfffiles", "{}.gff".format(name))
    nucleotides = os.path.join(tmp + "/gms2results/nucleotidefasta", "{}.fna".format(name))
    proteins = os.path.join(tmp + "/gms2results/proteinfasta", "{}.faa".format(name))
    subprocess.call(["../../team1tools/GenePrediction/gms2_linux_64/gms2.pl", "--seq", input, "--genome-type", "bacteria", "--output", gff, "--format", "gff", "--fnn", nucleotides, "--faa", proteins])
    print("-" * 20 + "genemark done")


def prodigal(name, input, tmp):
    if os.path.exists(tmp + "/prodigalresults") != True:
        subprocess.call(["mkdir", tmp + "/prodigalresults"])
    if os.path.exists(tmp + "/prodigalresults/nucleotide") != True:
        subprocess.call(["mkdir", tmp + "/prodigalresults/nucleotide"])
    if os.path.exists(tmp + "/prodigalresults/protein") != True:
        subprocess.call(["mkdir", tmp + "/prodigalresults/protein"])
    if os.path.exists(tmp + "/prodigalresults/gff") != True:
        subprocess.call(["mkdir", tmp + "/prodigalresults/gff"])

    protein = os.path.join(tmp + "/prodigalresults/protein", "{}.faa".format(name))
    nucleotide = os.path.join(tmp + "/prodigalresults/nucleotide", "{}.fna".format(name))
    gff = os.path.join(tmp + "/prodigalresults/gff", "{}.gff".format(name))
    subprocess.call(["../../team1tools/GenePrediction/Prodigal/prodigal", "-i", input, "-a", protein, "-d", nucleotide, "-o", gff, "-f", "gff"])
    subprocess.call(['rm', '-f', 'GMS2.mod'])
    subprocess.call(['rm', '-f', 'log'])
    print("-" * 20 + "prodigal done")


def bedtools_func(name, input, tmp):
    if os.path.exists(tmp + "/prodigal-genemark") != True:
        subprocess.call(['mkdir', tmp + '/prodigal-genemark'])
    if os.path.exists(tmp + "/prodigal-genemark/gfffiles") != True:
        subprocess.call(['mkdir', tmp + '/prodigal-genemark/gfffiles'])
    if os.path.exists(tmp + "/prodigal-genemark/gfffilesunion") != True:
        subprocess.call(['mkdir', tmp + '/prodigal-genemark/gfffilesunion'])
    if os.path.exists(tmp + "/prodigal-genemark/nucleotides") != True:
        subprocess.call(['mkdir', tmp + '/prodigal-genemark/nucleotides'])
    if os.path.exists(tmp + "/prodigal-genemark/aminoacids") != True:
        subprocess.call(['mkdir', tmp + '/prodigal-genemark/aminoacids'])

    # gets gff files from prodigal
    prodigal_gff = os.path.join(tmp + '/prodigalresults', 'gff', '{}.gff'.format(name))
    # gets gff files from genemark
    genemark_gff = os.path.join(tmp + '/gms2results', 'gfffiles', '{}.gff'.format(name))
    # gets intersect from genemark and prodigal
    intersect1 = os.path.join(tmp + '/prodigal-genemark/gfffiles', '{}intersect1.gff'.format(name))
    intersect2 = os.path.join(tmp + '/prodigal-genemark/gfffiles', '{}intersect2.gff'.format(name))
    # gets common from genemark and prodigal
    common = os.path.join(tmp + '/prodigal-genemark/gfffiles', '{}common.gff'.format(name))
    # gets union
    union = os.path.join(tmp + '/prodigal-genemark/gfffilesunion', '{}union.gff'.format(name))
    # command for intersect
    bedtools_intersect1 = ['../../team1tools/GenePrediction/bedtools2/bin/bedtools intersect -f 1.0 -r -wa -v -a {} -b {} > {}'.format(prodigal_gff, genemark_gff, intersect1)]
    bedtools_intersect2 = ['../../team1tools/GenePrediction/bedtools2/bin/bedtools intersect -f 1.0 -r -wa -v -b {} -a {} > {}'.format(prodigal_gff, genemark_gff, intersect2)]
    # command for common
    bedtools_common = ['../../team1tools/GenePrediction/bedtools2/bin/bedtools intersect -f 1.0  -r -a {} -b {} > {}'.format(prodigal_gff, genemark_gff, common)]

    subprocess.call(bedtools_intersect1, shell=True)
    subprocess.call(bedtools_intersect2, shell=True)
    subprocess.call(bedtools_common, shell=True)
    print("common done")
    # concatenates to get union
    cat = ['cat {0} {1} {2} > {3}'.format(intersect1, intersect2, common, union)]
    subprocess.call(cat, shell=True)
    print("cat done")
    # dir = tmp + "/fai"
    # creates fasta index
    createfastaindex = ['../../team1tools/GenePrediction/samtools-1.9/bin/samtools', 'faidx', input]
    subprocess.call(createfastaindex)
    nucleotides = os.path.join(tmp, "prodigal-genemark/nucleotides", "{}.fna".format(name))
    amino = os.path.join(tmp, "prodigal-genemark/aminoacids", "{}.faa".format(name))
    fastasequences = ['../../team1tools/GenePrediction/bedtools2/bin/bedtools', 'getfasta', '-fo', nucleotides, '-fi', input, '-bed', union]
    subprocess.call(fastasequences)

    dnatoaapy = os.path.join("../../team1tools/GenePrediction", "nucl2prot.py")
    subprocess.call(['../../t1g5/bin/python3', dnatoaapy, nucleotides, amino])
    subprocess.call(['rm', '-f', '{}.fai'.format(name)])
    # todo: move result to uploads/predict


## functional_annotation
def vfdbBlast(inputFile):
    subprocess.call(["team1tools/FunctionalAnnotation/ncbi-blast-2.9.0+/bin/blastn",  # todo: fix path
                     "-db", "team1tools/FunctionalAnnotation/vfDB",
                     "-query", inputFile,
                     "-num_threads", "4",
                     "-evalue", "1e-10",
                     "-outfmt", "'6 stitle qseqid pident qcovs qstart qend qseq evalue bitscore'",
                     "-best_hit_score_edge", "0.1",
                     "-best_hit_overhang", "0.1",
                     "-max_target_seqs", "1",
                     "-out", "vfdb_temp"])


def vfdb_to_gff(inputFile, outputFile):
    output_name = outputFile + ".gff"
    output = open(output_name, "w+")

    with open(inputFile, "r", encoding='latin-1') as fh:
        for l in fh:
            l = l.strip("\n").split("\t")
            notes = l[0]
            seqid = l[1]
            start = l[5]
            end = l[8]
            output.write("{}\tVFDB-BLAST\tBacterial Virulent genes\t{}\t{}\t.\t.\t.\t{}\n".format(seqid, start, end, notes))
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
def assemble_genomes(_tmp_dir, jobname):
    """
    run different assemblers and choose the best result
    :param _tmp_dir: tmp directory
    :param _assemblers: assemblers given by user
    :return: None
    """
    # spades
    run_spades(_tmp_dir)
    # quast
    subprocess.call(["../../team1tools/GenomeAssembly/quast-5.0.2/quast.py", _tmp_dir + "/spades/scaffolds.fasta", "-o", _tmp_dir + "/quast"])
    quast_result = "%s/quast/report.tsv" % _tmp_dir
    try:
        result = pd.read_table(quast_result, index_col=0)
    except FileNotFoundError:
        print("quast report does not exist!")
        print("Abort")
        return
    result.loc["score"] = np.log(result.loc["Total length (>= 0 bp)"] * result.loc["N50"] / result.loc["# contigs"])
    result.to_csv("../storage/app/uploads/assemble/" + jobname + "_quast.csv", header=True, index=True)
    print("-" * 20 + "quast finished" + "-" * 20)

    subprocess.call(["mv", _tmp_dir + "/spades/scaffolds.fasta", "../storage/app/uploads/assemble/" + jobname + "_genome.fasta"])


def run_spades(_tmp_dir):
    """
    run spades on trimmed file
    :param _tmp_dir: tmp directory
    :return: output contigs file name
    """
    spades_cmd = ["../../team1tools/GenomeAssembly/SPAdes-3.11.1-Linux/bin/spades.py", "--phred-offset", "33", "-k", "99", "-1", "{0}/trimmed_1P.fastq".format(_tmp_dir), "-2",
                  "{0}/trimmed_2P.fastq".format(_tmp_dir), "-o", "{0}/spades".format(_tmp_dir)]
    if "trimmed_U.fastq" in os.listdir(_tmp_dir):
        spades_cmd.extend(["-s", "{0}/trimmed_U.fastq".format(_tmp_dir)])
    subprocess.call(spades_cmd, stderr=subprocess.DEVNULL, stdout=subprocess.DEVNULL)


def run_fake_trim(trimmomatic_jar, _input_files, _tmp_dir):
    """
    generate fastq file for assembler, do not change file content
    :param trimmomatic_jar: trimmomatic jar file
    :param _input_files: input fastq file
    :param _tmp_dir: tmp directory
    :return: None
    """
    prefix = "../storage/app/uploads/"
    print("running fake trim")
    command = ["java", "-jar", trimmomatic_jar, "PE", prefix + _input_files[0], prefix + _input_files[1], "-baseout", _tmp_dir + "/trimmed.fastq", "MINLEN:100"]
    subprocess.call(command, stderr=subprocess.DEVNULL)
    subprocess.call(["rm", "-rf", "{0}/trimmed_*U.fastq".format(_tmp_dir)])


def run_fastqc(_input_file, _tmp_dir):
    """
    run fastqc for each file
    :param _input_file: input fastq file
    :param _tmp_dir: tmp directory
    :return: None
    """
    fastqc = subprocess.call(["../../team1tools/GenomeAssembly/FastQC/fastqc", "--extract", "-o", _tmp_dir, _input_file])


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
        data_file_name = "{0}/{1}/{1}/fastqc_data.txt".format(_tmp_dir, dir)
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
    prefix = "../storage/app/uploads/"
    command = ["java", "-jar", trimmomatic_jar, "PE", prefix + _input_files[0], prefix + _input_files[1], "-baseout", _tmp_dir + "/trimmed.fastq"]
    command.append("HEADCROP:%d" % headcrop)
    command.append("CROP:%d" % crop)
    command.extend(["SLIDINGWINDOW:%d:%d" % (window, threshold), "MINLEN:100"])
    # print("trim cmd", command)
    proc = subprocess.Popen(command, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
    proc.wait()
    out, trim_summary = proc.communicate()
    # print("----TRIM----", out, trim_summary)
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
    prefix = "../storage/app/uploads/"
    for i, file in enumerate(input_files):
        fastqc_dirs[i] = os.path.split(file)[-1].rstrip(".fastq") + "_fastqc"
        os.mkdir(tmp_dir + "/" + fastqc_dirs[i])
        run_fastqc(prefix + file, tmp_dir + "/" + fastqc_dirs[i])
        os.remove("{0}/{1}/{1}.html".format(tmp_dir, fastqc_dirs[i]))
        os.remove("{0}/{1}/{1}.zip".format(tmp_dir, fastqc_dirs[i]))
    print("-" * 20 + "fastqc finished" + "-" * 20)

    with open("{0}/{1}/{1}/summary.txt".format(tmp_dir, fastqc_dirs[0]), "r") as f1, open("{0}/{1}/{1}/summary.txt".format(tmp_dir, fastqc_dirs[1]), "r") as f2:
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
    drop_rate = 100
    while trim_condition is not False:
        subprocess.call(["rm", "-rf", "{0}/trimmed_*.fastq".format(tmp_dir)])
        drop_rate = run_trim(trimmomatic_jar, input_files, tmp_dir, *trim_condition)
        if drop_rate > 33 and trim_condition[0] != window_steps[-1]:
            trim_condition[0] = window_steps[window_steps.index(trim_condition[0]) + 1]
        else:
            trim_condition = False
        print("-" * 20 + "trim finished" + "-" * 20)
    if drop_rate > 33:
        run_fake_trim(trimmomatic_jar, input_files, tmp_dir)


if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    # I/O parameters
    parser.add_argument('--infastq', metavar=("file1", "file2"), nargs=2, help='input fastq')
    parser.add_argument('--infasta', help='input fasta')
    parser.add_argument('--outfile', help='output file name')
    parser.add_argument('-j', required=True, help='jobname')

    parser.add_argument('-a', action="store_true", help='do step 1')
    parser.add_argument('-b', action="store_true", help='do step 2')
    parser.add_argument('-c', action="store_true", help='do step 3')
    parser.add_argument('-d', action="store_true", help='do step 4')

    # parameters for genome assembly: None
    # parameters for gene prediction: None
    # parameters for functional annotation
    parser.add_argument('-f', help='card or vfdb')
    # parameters for comparative analysis

    # other parameters
    parser.add_argument('--email', default=None, help='email address(if given) used to send notification')

    args = parser.parse_args()
    tmp = "../storage/app/public/" + args.j
    if not os.path.exists(tmp):
        os.mkdir(tmp)
    else:
        shutil.rmtree(tmp)
        os.mkdir(tmp)

    if args.a:
        trim_files(args.infastq, tmp, "../../team1tools/GenomeAssembly/Trimmomatic-0.36/trimmomatic-0.36.jar")
        assemble_genomes(tmp, args.j)
    if args.b:
        if args.infasta:
            in_prediction = args.infasta
        else:
            in_prediction = "../storage/app/uploads/assemble/" + args.j + "_genome.fasta"
        prodigal(args.j, in_prediction, tmp)
        # genemark(args.j, in_prediction, tmp)
        # bedtools_func(args.j, in_prediction, tmp)
        subprocess.call(['mv', os.path.join(tmp + "/prodigalresults/protein", "{}.faa".format(args.j)), "../storage/app/uploads/prediction/"])
        subprocess.call(['mv', os.path.join(tmp + "/prodigalresults/nucleotide", "{}.fna".format(args.j)), "../storage/app/uploads/prediction/"])
        subprocess.call(['mv', os.path.join(tmp + "/prodigalresults/gff", "{}.gff".format(args.j)), "../storage/app/uploads/prediction/"])
    if args.c:
        annotation_result = "annotation"
        if args.f == "card":
            # CARD(predict_result, )
            pass
        else:
            # vfdb()
            pass
    else:
        annotation_result = args.infasta
    if args.d:
        pass
    subprocess.call(["rm", "-rf", "../storage/app/uploads/meinv"])
    print("main.py finished!")
