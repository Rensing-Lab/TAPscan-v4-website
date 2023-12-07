#!/usr/bin/env python3
import sys

def changeStockholm(stockholm):
  with open("MAFFT_reducedAlignment_trim.sto", "r", encoding="utf-8") as file:
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
