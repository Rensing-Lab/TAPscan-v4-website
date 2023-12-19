# Reduce trees website

Main bash script

```bash
#!/bin/bash

### Pipeline to remove identical sequences (identitiy over 90%) in an
alignment and to calculate phylogenetic trees

for i in *fa
do
NAME=$(basename $i .fa)

##1. Run needleall
echo Run needleall
needleall \
-gapopen 20.0 \
-gapextend 0.2 \
-asequence $i \
-bsequence $i \
-outfile output_needleall \
-datafile EBLOSUM30 \
-aformat par \

rm needleall.error

##2. Detect identical sequences
echo Detect identical sequences

python script/convertOutput_needleall.py

##3. Build new reduced alignment
echo Build new reduced alignment

python script/filter_Sequences_v3.py

./needleall_statistics $i

echo Run MAFFT
mafft \
--thread 2 \
--reorder \
--ep 0.0 \
--auto \
reducedAlignment.fasta > MAFFT_reducedAlignment.fasta

##4. Trimming
echo Trimming using trimAl

trimal \
-in MAFFT_reducedAlignment.fasta \
-out MAFFT_reducedAlignment_trim.fasta \
-gt 0.5 \
-st 0.001

echo Convert to Stockholm format

esl-alimanip \
--outformat stockholm \
MAFFT_reducedAlignment_trim.fasta \
> MAFFT_reducedAlignment_trim.sto

##5. Edit stockholm format
echo Edit Stockholm format

python script/adjustStockholm.py

##6. Calculating NJ-tree
echo Calculate NJ-tree using quicktree

quicktree \
-boot 100 \
MAFFT_reducedAlignment_trim_ad.sto \
> quicktree_reducedAlignment.tre

rm output_needleall

##7. Calculating ML-tree
echo Calculate ML-tree using IQ-tree

iqtree \
-s MAFFT_reducedAlignment_trim.fasta \
-alrt 1000 \
-bb 1000 \
-nt AUTO \
-m MFP

echo Done
```

convertOutput_needleall.py

```python
import re

def run_needleall(files):
r = open('output_needleall', 'r')
w = open('needleall_statistics', 'w')
in_aligned = False
one = ""
two = ""
to_print = False
length = -1
identity = ""
similarity = ""
gaps = ""
score = ""
w.write("seq1\tseq2\talLength\tpctIdent\tpctSim\tpctGaps\tscore\n")
for line in r:
line = line.strip()
if "# Aligned_sequences" in line:
in_aligned = True
if in_aligned:
if line.startswith("# 1: "):
one = line.split("# 1: ")[1]
elif line.startswith("# 2: "):
two = line.split("# 2: ")[1]
if one != two:
to_print = True
if to_print:
if "# Length:" in line:
length = line.split()[-1]
elif "# Identity:" in line:
identity = line.strip(")").split("(")[-1][:-1]
elif "# Similarity:" in line:
Printed on 2023/12/06 20:322023/12/06 20:32
3/5
Reduce trees website
similarity = line.strip(")").split("(")[-1][:-1]
elif "# Gaps:" in line:
gaps = line.strip(")").split("(")[-1][:-1]
elif "# Score:" in line:
score = line.split()[-1]
if "# Score:" in line:
if one != "" and two != "" and score != "":
w.write("%s\t%s\t%s\t%s\t%s\t%s\t%s\n" % (one, two, length,
identity, similarity, gaps, score))
in_aligned = False
one = ""
two = ""
to_print = False
length = -1
identity = ""
similarity = ""
gaps = ""
score = ""
r.close()
w.close()
def main():
folder = "./"
fastas = []
run_needleall('*.fa')
if __name__ == '__main__':
main()
fi l t e r _ S e q u e n c e s _ v 3 . p y
#!/usr/bin/env python3
import sys
def detectSequences(needleOutput):
with open('needleall_statistics',"r",encoding="utf-8") as needlestat:
with open("identical_sequences.txt","w") as identSequences:
identSequences.write("seq1(kept)
seq2
alLength
pctIdent
pctSim
pctGaps
score\n")
lines=[]
seq2=[]
var1=[]
var2=[]
count=0
for line in needlestat:
if not line.startswith("seq1"):Last update: 2023/12/06
20:25
ident = line.split()[3]
numIdent=float(ident)
if numIdent >= 90:
if line.split()[0] != line.split()[1]:
lines.append(line)
seq2.append(line.split()[1])
var1.append(line.split()[1])
var1.append(line.split()[0])
l=[[i,j] for i,j in zip(var1[::2],var1[1::2])]
for x in lines:
var3=[x.split()[0],x.split()[1]]
var4=[x.split()[1],x.split()[0]]
for z in l:
if var3 or var4 == z:
var2.append(z)
if len(var2) > 1:
l.remove(var4)
for y in l:
if var3 == y:
identSequences.write(x)
var3=[]
def newAlignment(oldSequences,needlestat):
with open(needlestat,"r",encoding="utf-8") as needlestat:
with open(oldSequences,"r",encoding="utf-8") as oldSequences:
with open('reducedAlignment.fasta','w') as reducedSequences:
seqToDelete=[]
count=0
var5=0
for line in needlestat:
if not line.startswith("seq1"):
seq1=line.split()[1]
seqToDelete.append(seq1)
for seq in oldSequences:
if seq.startswith(">"):
count = 0
for x in seqToDelete:
seqname=seq.split()[0]
finalseqname=seqname[1:]
if finalseqname == x:
count += 1
if count == 0:
reducedSequences.write(seq)
def main():
detectSequences(sys.argv[1])
newAlignment(sys.argv[2],"identical_sequences.txt")
Printed on 2023/12/06 20:322023/12/06 20:32
5/5
Reduce trees website
if __name__ == "__main__":
main()
adjustStockholm.py
#!/usr/bin/env python3
import sys
def changeStockholm(stockholm):
with open("MAFFT_reducedAlignment_trim.sto", "r", encoding="utf-8") as
file:
with open("./MAFFT_reducedAlignment_trim_ad.sto","w") as newFile:
for line in file:
if line.startswith("# STOCKHOLM"):
newFile.write(line)
elif not line.startswith("#") and not line.startswith("\n"):
newFile.write(line)
def main():
changeStockholm("MAFFT_reducedAlignment_trim.sto")
if __name__ == "__main__":
main()

