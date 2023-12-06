<!DOCTYPE html>

@extends('layout')

@section('content')

<div class="container">
  <div class="row">
  <div class="jumbotron jumbotron-fluid">
    <div class="container">
    <h1 class="display-6">TAPscan - Families</h1>
    <p class="lead">This is a list of all TAPs covered by the TAPscan web page. Clicking them will lead you to a list of species in which these TAP families occur. The number of proteins containing the respective TAP is written in brackets after its name.</p>
    <hr class="my-1">
    <p>Transcriptional regulation is carried out by transcription associated proteins (<span style="color:green">TAPs</span>), comprising <span style="color:green">transcription factors</span> 
(TFs, binding in sequence-specific manner to cis-regulatory elements to enhance or repress transcription), 
<span style="color:green">transcriptional regulators</span>
 (TRs, acting as part of the transcription core complex, via unspecific binding, protein-protein interaction or chromatin modification) and <span style="color:green">putative TAPs</span>
 (PTs), the role of which needs to be determined. </p>
  <p>The colour of the TAP name corresponds to the TAP class: <span class="TF">TF</span>, <span class="TR">TR</span> and <span class="PT">PT</span>
  </p>
  </div>

</div>
</div>

<style>

.TF { color:#F5793A; }
.TR { color:#A95AA1; }
.PT { color:#3490dc; }

</style>

<div class="container">
  <div class="row row-cols-6">
@foreach ($tap_count as $tap)
      @if ($loop->index)
        <span class="border rounded" id="stuff">
         <div class="col justify-content-between align-items-center d-flex"><a class='{{ $tap->type }}' href='/tap/{{ $tap->tap_1}}'> {{ $tap->tap_1}} </a>
         <span class="badge badge-success badge-pill">{{ $tap->num}}</span>
         </div>
         </span>
      @endif
@endforeach
  </div>
</div>


<br>

</div>





{{--
  @php
   $count_z = 0;
   $table_rows = 6;
   $class_color = "";
  @endphp

  @foreach ($family as $row)

    @php
    if ($row->class_id === 1) {
       $color = "green tablelink";
    }elseif ($row->class_id === 2) {
       $color = "orange tablelink";
    }else{
       $color = "yellow tablelink";
    }
    @endphp

    @if ($count_z%$table_rows === 0)
      <tr>
        <td class="sameHeight">
          <b><a class="{{$color}}">{{ $row->name }} ({{ $row->num_proteins}})</a></b>
        </td>
    @elseif ($count_z%$table_rows > 0)
      <td class="sameHeight">
        <b><a class="{{$color}}">{{ $row->name }} ({{ $row->num_proteins}})</a></b>
      </td>
    @elseif ($count_z%$table_rows === 0)
      </tr>
    @endif

    @php
      $count_z === $count_z++;
    @endphp

  @endforeach --}}




{{-- @if (count($records) === 1)
    I have one record!
@elseif (count($records) > 1)
    I have multiple records!
@else
    I don't have any records!
@endif --}}

{{-- @include('footer') --}}

@endsection
