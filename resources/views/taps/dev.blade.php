@extends('layout')

@section('content')
<div class="container">
  <div class="row">
  <div class="jumbotron jumbotron-fluid">
    <div class="container">
     <h1 class="display-6">Dev View</h1>
     <p class="lead"> Below some stats and missing data to look at adding</p>
     <hr class="my-1">
     <p> This is a temporary page to help with development. This page is automatically generate based on the contents of the current TAPscan v4 database, so will automatically change as we add more data. (If you think anything on this page is wrong, it might be, just let me know)!</p>
    </div>
  </div>
</div>

<!--
domain table:    id,name,pfam
taps table:      id, tap_id, tap_1, tap_2, count, tap_3
species_tax_ids: id, lettercode, name, taxid
tap_rules:       id, tap_1, tap_2, rule     # (tap_2 is domain)
sequences:       id, tap_id, sequence
tap_infos        id, tap, text, reference, type
-->

<!-- { {  dd(get_defined_vars()['__data']) }} -->

<h5>Some stats of data in database</h5>
Number of TAP families: {{ count($tap_count) }} <br>
Number of TAP subfamilies: {{ count($tap_count2) }} <br>
Number of TAPs with info: {{ count($db_tap_infos) }} <br>
<br>
Number of Species: {{count($db_species_tax_ids) }} <br>
Number of Domains: {{count($db_domains) }} <br>
Number of TAP Rules: {{count($db_tap_rules) }} <br>
<br>

<h5>Missing TapInfo Data</h5>
 <details>
  <summary>TAP families with missing TapInfo</summary>
  <p>
  @foreach ($tap_count as $tap)
  @php $i = "missing" @endphp
  @foreach ($db_tap_infos as $info)
    @if ($info->tap === $tap->tap_1)
      @php $i = "present" @endphp
    @endif
  @endforeach
  @if ($i === "missing")
  {{$tap->tap_1}} | {{$i}}
  <br>
  @endif
  @endforeach
  </p>
</details>

<details>
  <summary>TAP subfamilies with missing TapInfo</summary>
  <p>
  @foreach ($tap_count2 as $tap)
  @php $i = "missing" @endphp
  @foreach ($db_tap_infos as $info)
    @if ($info->tap === $tap->tap_2)
      @php $i = "present" @endphp
    @endif
  @endforeach
  @if ($i === "missing")
  {{$tap->tap_2}} | {{$i}}
  <br>
  @endif
  @endforeach
  </p>
</details>

 <details>
  <summary>Obsolete TapInfo (TapInfo in our database not corresponding to any TAP)</summary>
  <p>
  @foreach ($db_tap_infos as $info)
  @php $i = "unused" @endphp
  @foreach ($tap_count as $tap)
    @if ($info->tap === $tap->tap_1)
      @php $i = "present" @endphp
    @endif
  @endforeach
  @foreach ($tap_count2 as $tap)
    @if ($info->tap === $tap->tap_2)
      @php $i = "present" @endphp
    @endif
  @endforeach

  @if ($i === "unused")
  {{$info->tap}} | {{$i}}
  <br>
  @endif
  @endforeach
  </p>
</details>
  <details>
  <summary>How to Fix</summary>
  <p>To add TAP info, we need a tab-separate file with 4 columns: <code>TAP_name [TAB] description [TAB] "reference1","reference2" [TAB] type (TR|TF|PT)</code></p>
  <p>Make sure the TAP_name matches those in TAPscan output</p>
  <p><a target="_blank" href="https://github.com/Rensing-Lab/TAPscan-v4-website/blob/main/_data/import-tap/taps_v4.csv">Example TAPs file</a></p>
  </details>
<br>
<h5>Missing Species Data</h5>
  <details>
  <summary>Species in database without TAP results</summary>
  <p>
    @foreach ($db_species_tax_ids as $species)
     @php $i = "none" @endphp
     @foreach ($db_tap_table_species as $species2)
       @if ($species->lettercode == $species2->species)
        @php $i = "found" @endphp
       @endif
     @endforeach
     @if ($i != "found")
       {{$species->lettercode}} | {{$i}} <br>
     @endif

    @endforeach
  </p>
  </details>

  <details>
  <summary>Species with TAP results but not in database</summary>
  <p>
   @foreach ($db_tap_table_species as $species)
      @php $i = "none" @endphp
     @foreach ($db_species_tax_ids as $species2)
       @if ($species->species == $species2->lettercode)
        @php $i = "found" @endphp
       @endif
     @endforeach
     @if ($i != "found")
       {{$species->species}} | {{$i}} <br>
     @endif
   @endforeach
  </p>
  </details>

  <details>
  <summary>How to Fix</summary>
  <p>To add Species info, we need a semi-colon separated file with 8 columns: <code>lettercode;Kingiom/supergroup;phylum/clade; supergroup2;order;family;scientific name;NCBI TaxID</code></p>
  <p>Make sure the lettercode matches those in TAPscan output</p>
  <p><a target="_blank" href="https://github.com/Rensing-Lab/TAPscan-v4-website/blob/main/_data/import-species/species_v4.csv">Example species file</a></p>
  </details>


<br>
<h5>Missing Tree Data</h5>

<details>
  <summary>TAP families without a tree:</summary>
   <p>
@foreach ($tap_count as $tap)
  @php $i = "none"; $t = str_replace("/","_",$tap->tap_1); @endphp
  @if (Storage::disk('public')->exists("trees/quicktree_reducedAlignment_".$t.".tre"))
    @php $i = "tree" @endphp
  @endif
  @if (Storage::disk('public')->exists("trees/quicktree_alignment_".$t.".tre"))
    @php $i = "tree" @endphp
  @endif
  @if (Storage::disk('public')->exists("trees/MAFFT_reducedAlignment_trim.fasta_".$t.".treefile"))
      @php $i = "tree" @endphp
  @endif
  @if (Storage::disk('public')->exists("trees/MAFFT_alignment_trim.fasta_".$t.".treefile"))
      @php $i = "tree" @endphp
  @endif
  @if ($i == "none")
   {{$tap->tap_1}} <br>
  @endif
@endforeach
</p>
</details>

<details>
  <summary>TAP subfamilies without a tree:</summary>
   <p>
@foreach ($tap_count2 as $tap)
  @php $i = "none"; $t = str_replace("/","_",$tap->tap_2); @endphp
  @if (Storage::disk('public')->exists("trees/quicktree_reducedAlignment_".$t.".tre"))
    @php $i = "tree" @endphp
  @endif
  @if (Storage::disk('public')->exists("trees/quicktree_alignment_".$t.".tre"))
    @php $i = "tree" @endphp
  @endif
  @if (Storage::disk('public')->exists("trees/MAFFT_reducedAlignment_trim.fasta_".$t.".treefile"))
      @php $i = "tree" @endphp
  @endif
  @if (Storage::disk('public')->exists("trees/MAFFT_alignment_trim.fasta_".$t.".treefile"))
      @php $i = "tree" @endphp
  @endif
  @if ($i == "none")
   {{$tap->tap_2}} <br>
  @endif
@endforeach
</p>
</details>

<details>
  <summary>Trees without an image (Saskia to make images)</summary>
   <p>
@foreach ($treefiles as $tree)
  @if ($tree['type'] == 'file')

    @php $i = "none"; @endphp
    @if ($tree['extension'] == "treefile" || $tree['extension'] == "tre")
      @if (Storage::disk('public')->exists("trees/svgs/".$tree['basename'].".svg"))
        @php $i = "svg" @endphp
      @endif
      @if ($i == 'none')
        {{$tree['path'] }} | missing an svg <br>
      @endif
    @endif
  @endif
@endforeach
</p>
</details>


<br>
<h5>Missing Domains Data</h5>

<details>
<summary>Domains referenced in rules but not in domain table</summary>
<p>
  @foreach ($db_tap_rules as $rule)
    @php $i='none' @endphp
    @foreach ($db_domains as $domain)
	  @if ($rule->tap_2 == $domain->name)
        @php $i = "found" @endphp
      @endif
	@endforeach
    @if ($i == 'none')
     {{$rule->tap_2}} | missing <br>
    @endif
  @endforeach
</p>
</details>

<details>
<summary>Domains in domain table but never referenced in rule</summary>
<p>
  @foreach ($db_domains as $domain)
    @php $i='none' @endphp
    @foreach ($db_tap_rules as $rule)
	  @if ($domain->name == $rule->tap_2)
        @php $i = "found" @endphp
      @endif
	@endforeach
    @if ($i == 'none')
     {{$domain->name}} | missing <br>
    @endif
  @endforeach
</p>
</details>

<details>
  <summary>Misc</summary>
  Check the <a href="/domain">domains table</a>, are all custom domains really custom, or just missing PFAM ID?
</details>


@endsection
</div>
