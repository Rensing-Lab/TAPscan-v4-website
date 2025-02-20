# request all pages in tapscan once, to populate the page-cache and improve performance
# the slowest pages are the ones with the tables on them (home page and species pages)

numspecies=678
delay=10 # delay between requests, don't overwhelm the server, this script takes ~90 minutes at a delay of 10 seconds

# get the main page
wget -O /dev/null https://tapscan.plantcode.cup.uni-freiburg.de

# get all the species pages
for i in $(seq 1 $numspecies);
do
  wget -O /dev/null https://tapscan.plantcode.cup.uni-freiburg.de/species/$i
  sleep $delay
done
