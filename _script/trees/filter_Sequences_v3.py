#!/usr/bin/env python3
import sys

def detectSequences(needleOutput):
  with open('needleall_statistics',"r",encoding="utf-8") as needlestat:
    with open("identical_sequences.txt","w") as identSequences:
      identSequences.write("seq1(kept) seq2 alLength pctIdent pctSim pctGaps score\n")
      lines=[]
      seq2=[]
      var1=[]
      var2=[]
      count=0
      for line in needlestat:
        if not line.startswith("seq1"):
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


if __name__ == "__main__":
  main()
