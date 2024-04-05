<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {

        DB::table('news')->insert([
            'name' => "Imported TAPscan v3 news",
            'content' => "
**30.07.2021** <br>
TAPscan V3 is out! Data of 10 red algae were added. The [publication in Genes](https://www.mdpi.com/2073-4425/12/7/1055) also describes the refinement of several TAP families in terms of enhanced sensitivity for algae. In addition, data derived from genomes meanwhile published have been released.
<br><br>
**13.07.2018**
<br>
The data derived from the genome of Chara braunii are released after [publication in Cell](https://authors.elsevier.com/a/1XNJfL7PXUhso).
<br><br>
**06.07.2018**
<br>
The data derived from the genomes of Azolla filiculoides and Salvinia cucullata are released after [publication in Nature Plants](https://www.nature.com/articles/s41477-018-0188-8).
<br><br>
**08.01.2018**
<br>
TAPscan and [PLAZA](https://bioinformatics.psb.ugent.be/plaza/) now cross link to each other on the level of individual proteins. When looking at a TAPscan protein sequence, please follow the 'Search for the protein on PLAZA' link to access the protein in PLAZA.
<br><br>
**08.12.2017**
<br>
TAPscan was published December 2017, please cite: <br>
**TAPscan - Comprehensive genome-wide classification reveals that many plant-specific transcription factors evolved in streptophyte algae. Wilhelmsson P.K., Mühlich C., Ullrich K.K., Rensing S.A. (2017) [Genome Biology and Evolution, evx258](https://academic.oup.com/gbe/advance-article/doi/10.1093/gbe/evx258/4693820?guestAccessKey=fc717224-f2bb-452b-91a2-982f5fbd7489)**
",
            'created_at' => date("Y-m-d H:i:s") ,
            'updated_at' => date("Y-m-d H:i:s") ,

        ]);

        DB::table('news')->insert([
            'name' => "TAPscan v4 is out!",
            'content' => '
We are happy to announce the new version 4 of TAPscan. This comprehensive update includes the addition of 23 new (sub) families, allowing TAPscan v4 to detect 145 TAP families. This update also includes an updated web interface, which enables to interactively explore the TAP data. By incorporating the <a target="_blank" href="https://github.com/Rensing-Lab/Genome-Zoo"> Genomezoo dataset</a>, in addition to TAP data of the Archaeplastida, now also data of selected fungi, mammals, SAR group species, bacteria and archaea is made available throughout the TAPscan web interface.
<br><br>
TAPscan v4 has also been made available as a Galaxy tool as part of the European Galaxy server (<a target="_blank" href="https://usegalaxy.eu">usegalaxy.eu</a>).
<br><br>
In addition, the TAP information derived from the recently published (updated) genomes of Takakia lepidozioides (Hu et al., 2023), Mesotaenium endlicherianum  (Dadras et al., 2023) and Zygnema circumcarinatum (Feng et al., 2023) is made available.
<br><br>
More information about the update can be found within the TAPscan v4 publication in The Plant Journal (in submission)!
',
            'created_at' => date("Y-m-d H:i:s") ,
            'updated_at' => date("Y-m-d H:i:s") ,

        ]);
    }
}
