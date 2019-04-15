#!/usr/bin/env python3

import subprocess

def vfdbBlast(inputFile, outputFile):
	#BLAST input query against VFDB
	#Filepaths assume script being run from predicta directory
	subprocess.call(["team1tools/FunctionalAnnotation/ncbi-blast-2.9.0+/bin/blastn",
					"-db", "team1tools/FunctionalAnnotation/vfDB", 
					"-query", inputFile, 
					"-num_threads", "4", 
					"-evalue" ,"0.1", 
					"-outfmt", "'6 stitle qseqid pident qcovs qstart qend qseq evalue bitscore'",
                	"-best_hit_score_edge", "0.1", 
                	"-best_hit_overhang", "0.1",
                	"-max_target_seqs", "1", 
                	"-out", outputFile])