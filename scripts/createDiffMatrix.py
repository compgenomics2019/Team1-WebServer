import csv
import numpy
import itertools

def main(inputFile,outputFile):
    with open(inputFile,newline='') as csv_file:
        csv_reader=csv.reader(csv_file,delimiter=",")
        next(csv_reader, None) #skip header
        row_list=list(csv_reader) #all rows in cgMLST_matrix file, has 50 rows
        nameList=[l[0] for l in row_list]
        m=createMatrix(nameList,len(nameList))
        idx_list=[i for i in range(50)]
        pairs_list=list(itertools.combinations(idx_list,2))
        
        for pair in pairs_list:
            gene1,gene2=row_list[pair[0]][1:],row_list[pair[1]][1:] #[1:] is to get rid of the first item CGT...
            gene1_idx,gene2_idx=pair[0]+1,pair[1]+1
            #print(gene1_idx,gene2_idx)
            diff=calDifference(gene1,gene2)
            m[gene1_idx][gene2_idx]=diff 
            m[gene2_idx][gene1_idx]=diff
        #print(DataFrame(m))
    with open (outputFile,"w") as outFile: #use csv.writer
        wr = csv.writer(outFile)
        for r in m:
            wr.writerow(r)

def createMatrix(names,size):
    m=[[]]*(size+1)
    for i in range(size+1):
        m[i]=[[]]*(size+1)
    m[0][0]="name"
    for r in range(1,size+1):
        m[r][0]=names[r-1]
    for c in range(1,size+1):
        m[0][c]=names[c-1]
    #put 0= identical for m[i][j] where i==j, 100% means completely different
    for r in range(1,size+1):
        for c in range(1,size+1):
            if r==c:
                m[r][c]=0
    return m
def calDifference(gene1,gene2):
    #iterate to each col and count different
    diff_list=[i!=j for i,j in zip(gene1,gene2)] #[True, False,True, False...]
    diff_val=diff_list.count(False)/len(gene1) #count difference
    return round(diff_val,4)
if __name__=="__main__":
    main()