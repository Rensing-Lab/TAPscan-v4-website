# TAP files

Source files were created by Romy

To populate the TAPscan database, we will upload the family classifications output (`*.output.3`) from the TAPscan script to the admin interface.

the file `taps_v4_allfamilyclassifications.csv` is a concatenation of all of the `*.output.3` files in the `./source` folder. We combine the files to make it easier to upload to the TAPscan website.


## Notes

To concatenate all the per-species files, removing the headers:

```bash
echo "familiy classifications for all species" > taps_v4.csv
tail -n +2 -q source/*.output.3 >> taps_v4.csv
```

or to split an all-species file into a set of per-species files:

```
awk -F_ '{print>$1".output.3"}' TAPscan_outputs/speciesWebsite_v2.output.3

# add header lines because uploader assumes it
header="familiy classifications"

for file in ./*
do
    sed -i -e "1i\
$header" $file
done
```
