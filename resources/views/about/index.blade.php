<!DOCTYPE html>

@extends('layout')

@section('content')

  <div class="card">
    <div class="card-header text-center">
       About TAPscan
    </div>
    <div class="card-body">

      <p style="text-align:justify;">
            <b>The TAPscan (v1)</b> tool was published 2010 (Lang et al. in <a class="awith" target="_blank" href="https://academic.oup.com/gbe/article/573786/">GBE</a>).
            It combined the rule sets of three previous resources,
            <a class="awith" target="_blank" href="http://www.cosmoss.org/bm/plantapdb">PlanTAPDB</a> (Richardt et al. 2007
            <a class="awith" target="_blank" href="http://www.plantphysiol.org/content/143/4/1452?keytype=ref&amp;ijkey=tASgZ4CU0p04UJ6">Plant Physiol</a>),
            <a class="awith" target="_blank" href="http://planttfdb.cbi.pku.edu.cn/">PlantTFDB</a> (Guo et al. 2008
            <a class="awith" target="_blank" href="https://academic.oup.com/nar/article-lookup/doi/10.1093/nar/gkm841">NAR</a>) and
            <a class="awith" target="_blank" href="http://plntfdb.bio.uni-potsdam.de/v3.0/">PlnTFDB</a> (Riano-Pachon et al. 2009
            <a class="awith" target="_blank" href="https://academic.oup.com/nar/article-lookup/doi/10.1093/nar/gkp805">NAR</a>).
            <b>The TAPscan (v2)</b> web interface makes the genome-wide annotation of TAPs available for the community.
            TAPscan V2 was published in 2017 (Wilhelmsson et al.
            <a class="awith" target="_blank" href="https://academic.oup.com/gbe/advance-article/doi/10.1093/gbe/evx258/4693820?guestAccessKey=fc717224-f2bb-452b-91a2-982f5fbd7489">GBE</a>).
            The update to <b>TAPscan v3</b> includes the improvement of selected TAP families to annotate TAPs specifically in
            algae with higher sensitivity and specificity (<a target="_blank" href="https://doi.org/10.3390/genes12071055">Petroll et al., 2021</a>).
            The latest version <b>TAPscan v4</b> was published in 2024 and enables the detection of 138 TAP families (citation).
            In addition, an updated web interface is available, making through the incorporation of the Genomezoo database
            even more TAP data available for the community. TAPscan v4 has also been made available as a Galaxy tool as
            part of the European Galaxy server (<a target="_blank" href="https://usegalaxy.eu">usegalaxy.eu</a>).
            <br><br>

            Transcriptional regulation is carried out by transcription associated proteins (<b>TAP</b>s), comprising transcription factors
            (<b>TF</b>s, binding in sequence-specific manner to cis-regulatory elements to enhance or repress transcription), transcriptional
            regulators (<b>TR</b>s, acting as part of the transcription core complex, via unspecific binding, protein-protein interaction
            or chromatin modification) and putative TAPs (<b>PT</b>s), the role of which needs to be determined.

            <br><br>
            Protein names (e.g. in download and phylogenetic trees) are extended by a (typically five) letter code abbreviating the species,
            e.g. ORYSA = <i>ORYza SAtiva</i>. Please see <a class="awith" href="/species-list">this table</a> for the alphabetically sorted codes.
        </p>
        <p>
        <b>Source code and data availability on GitHub:</b>
        <ul>
          <li>TAPscan website: <a target="_blank" href="https://github.com/Rensing-Lab/TAPscan-v4-website">Rensing-Lab/TAPscan-v4-website </a> </li>
          <li>TAPscan classifiation tool: <a target="_blank" href="https://github.com/Rensing-Lab/TAPscan-classify">Rensing-Lab/TAPscan-classify</a> </li>
          <li>Genome Zoo/MAdLandDB: <a target="_blank" href="https://github.com/Rensing-Lab/Genome-Zoo">Rensing-Lab/Genome-Zoo</a> </li>

        </ul>
        </p>
    </div>
    <div class="card-footer text-muted text-center">
      Last updated 2024
    </div>
  </div>
  <br>


@endsection
