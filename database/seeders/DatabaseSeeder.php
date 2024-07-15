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
            'created_at' => date("Y-m-d H:i:s", mktime(12, 42, 0, 5, 24, 2024))  ,
            'updated_at' => date("Y-m-d H:i:s", mktime(12, 42, 0, 5, 24, 2024))  ,

        ]);

        DB::table('news')->insert([
            'name' => "TAPscan v4 is out!",
            'content' => '
We are happy to announce the new version 4 of TAPscan. This comprehensive update includes the addition of 18 new (sub) families, allowing TAPscan v4 to detect 138 TAP families. This update also includes an updated web interface, which enables to interactively explore the TAP data. By incorporating the <a target="_blank" href="https://github.com/Rensing-Lab/Genome-Zoo"> Genome Zoo dataset</a>, in addition to TAP data of the Archaeplastida, now also data of selected fungi, mammals, SAR group species, bacteria and archaea is made available throughout the TAPscan web interface.
<br><br>
TAPscan v4 has also been made available as a Galaxy tool as part of the European Galaxy server (<a target="_blank" href="https://usegalaxy.eu">usegalaxy.eu</a>).
<br><br>
In addition, the TAP information derived from the recently published (updated) genomes of Takakia lepidozioides (Hu et al., 2023), Mesotaenium endlicherianum  (Dadras et al., 2023) and Zygnema circumcarinatum (Feng et al., 2023) is made available.
<br><br>
More information about the update is available in the <a href="https://www.biorxiv.org/content/10.1101/2024.07.13.602682v1" target="_blank">TAPscan v4 preprint</a>.

See the <a href="/about">About page</a> for more information including version history and source code and data availability.
',
            'created_at' => date("Y-m-d H:i:s", mktime(12, 42, 0, 5, 24, 2024)) ,
            'updated_at' => date("Y-m-d H:i:s", mktime(12, 42, 0, 5, 24, 2024)) ,

        ]);
    }
}
