#! /bin/bash

# generate tree images for all trees
for i in ../*.tre*
do
 echo $i
 tree=`cat $i`
 name=$(basename $i)
 echo $name

 curl http://etetoolkit.org/get_svg/ \
    -X POST \
    -d "ncbitaxa=true;tree=$tree" > "${name}.svg"
done


