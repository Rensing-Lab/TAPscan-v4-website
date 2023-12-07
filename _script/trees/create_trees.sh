#!/bin/bash

### Pipeline to remove identical sequences (identitiy over 90%)
### in an alignment and to calculate phylogenetic trees

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

done

echo Done

