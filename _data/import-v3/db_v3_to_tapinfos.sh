# extract TAP information from v3 database for upload to v4
mysql TAPscan < db_v3_to_tapinfos.sql | awk -F'\t' -v OFS='\t' '{print $1,$2" ("$3"): " $4,"\""$5"\"",$6}' |  sed '1d' > tapinfos_export_from_v3.tsv
