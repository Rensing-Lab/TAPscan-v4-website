@extends('layout')

@section('content')
<div class="container">
  <div class="row">
  <div class="jumbotron jumbotron-fluid">
    <div class="container">
     <h1 class="display-6">Dev View</h1>
     <p class="lead"> Below some stats and missing data to look at adding</p>
     <hr class="my-1">
     <p> This is a temporary page to help with development</p>
    </div>
  </div>
</div>

<!--
domain table:    id,name,pfam
taps table:      id, tap_id, tap_1, tap_2, count, tap_3
species_tax_ids: id, lettercode, name, taxid
tap_rules:       id, tap_1, tap_2, rule
sequences:       id, tap_id, sequence
tap_infos        id, tap, text, reference, type
-->

<!-- { { dd(get_defined_vars()['__data']) }} -->

<h5>Some stats of data in database</h5>
<br>
Number of TAP families: {{ count($tap_count) }} <br>
Number of TAP subfamilies: {{ count($tap_count2) }} <br>
Number of TAPs with info: {{ count($db_tap_infos) }} <br>
<br>


<h5>Missing TapInfo Data</h5>
<p>To add TAP info, we need a file with columns: <code>TAP_name, description, reverences, type (TR|TF|PT)</code></p>
<p>Question: One of the descriptions Romy provided was for a TAP subfamily (MYST), should all subfamilies be listed on the main table? </p>
 <details>
  <summary>TAP families with missing TapInfo:</summary>
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
  <summary>TAP subfamilies with missing TapInfo:</summary>
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
  <summary>Obsolete TapInfo:</summary>
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

<br>
<h5>Missing Species Data</h5>
<p></p>

<br>
<h5>Missing Tree Data</h5>

<details>
  <summary>TAP families without a tree:</summary>
   <p>
@foreach ($tap_count as $tap)
  @php $i = "none" @endphp
  @if (Storage::disk('public')->exists("trees/quicktree_reducedAlignment_".$tap->tap_1.".tre"))
    @php $i = "tree" @endphp
  @endif
  @if (Storage::disk('public')->exists("trees/MAFFT_reducedAlignment_trim.fasta_".$tap->tap_1.".treefile"))
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
  @php $i = "none" @endphp
  @if (Storage::disk('public')->exists("trees/quicktree_reducedAlignment_".$tap->tap_2.".tre"))
    @php $i = "tree" @endphp
  @endif
  @if (Storage::disk('public')->exists("trees/MAFFT_reducedAlignment_trim.fasta_".$tap->tap_2.".treefile"))
      @php $i = "tree" @endphp
  @endif
  @if ($i == "none")
   {{$tap->tap_2}} <br>
  @endif
@endforeach
</p>
</details>


<br>
<h5>Missing Domains Data</h5>
<p></p>


@endsection
</div>
