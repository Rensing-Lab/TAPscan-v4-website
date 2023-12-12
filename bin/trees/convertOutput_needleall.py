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
          similarity = line.strip(")").split("(")[-1][:-1]
        elif "# Gaps:" in line:
          gaps = line.strip(")").split("(")[-1][:-1]
        elif "# Score:" in line:
          score = line.split()[-1]

    if "# Score:" in line:
      if one != "" and two != "" and score != "":
        w.write("%s\t%s\t%s\t%s\t%s\t%s\t%s\n" % (one, two, length, identity, similarity, gaps, score))
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
