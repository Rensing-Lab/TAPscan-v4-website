@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
  <div class="jumbotron jumbotron-fluid">
    <div class="container">
     <h1 class="display-6">Dev View</h1>
     <p> Below some stats and missing data to look at </p>
    </div>
  </div>
</div>

<!--
domain table:    id,name,pfam
taps table:      id, tap_id, tap_1, tap_2, count, tap_3
species_tax_ids: id, name, taxid
tap_rules:       id, tap_1, tap_2, rule
sequences:       id, tap_id, sequence
tap_infos        id, tap, text, reference, type
-->

<!-- { { dd(get_defined_vars()['__data']) }} -->

<br>
Number or TAP families: {{ count($tap_count) }} <br>
Number or TAPs subfamilies: {{ count($tap_count2) }} <br>
Number or TAPs (sub)families with info: {{ count($db_tap_infos) }} <br>
<br>
Missing TapInfo: <br>
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



@endsection
</dev>
