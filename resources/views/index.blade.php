<!DOCTYPE html>

@extends('layout')

@section('content')

{ { dd(get_defined_vars()['__data']) }}

<div class="container">
  <div class="row">
  <div class="jumbotron jumbotron-fluid">
    <div class="container">
      <h1 class="display-6">TAPscan - Family View</h1>
      <p class="lead">This is a list of all TAPs families covered by the TAPscan web page v4, in alphabetical order. Clicking them will lead you to a page with more details. There, the number of proteins containing the respective TAP is written in brackets after its name.
      For a list of all species covered by TAPscan, please refer to this <a href="/species">species tree</a> or <a href="/species-list">species table</a>.
      </p>
      <hr class="my-1">
      <h6> What are TAPs?</h6>
      <p>Transcriptional regulation is carried out by transcription associated proteins (TAPs), comprising <i>transcription factors</i>
         (TFs, binding in sequence-specific manner to cis-regulatory elements to enhance or repress transcription),
         <i>transcriptional regulators</i> (TRs, acting as part of the transcription core complex, via unspecific binding, protein-protein interaction or chromatin modification)
         and <i>putative TAPs</i> (PTs), the role of which needs to be determined.
      </p>
      <p>The colour of the TAP name corresponds to the TAP class:
      <span style="background-color:#317b22; color: #ffffff; font-weight: bolder">
        <span class="TF">TF</span>, <span class="TR">TR</span> and <span class="PT">PT</span>
      </span>
      <br/>
      and is shown behind the TAP name, together with the TAP count among <a href="/species">the species dataset used here</a>:
      <span class="badge badge-success badge-pill badge-tapcount"> TF | 42 </span><br>
      Subfamilies are also included in this table, and named like: <b><code>Family:Subfamily</code></b>
      </p>

    </div>
  </div>
</div>

<style>

.TF { color:#cdfecc; }
.TR { color:#fb9b00; }
.PT { color:#fefd98; }
.NA  { color:#ffffff; }
.taptext{ font-weight: bolder;}
.tapcell{ min-height: 2rem;}
.badge-tapcount {
  background-color: #f9db6d;
  color: #000000;
}

</style>

<div class="container">
  <div class="row row-cols-4">
   @php $offset = 0 @endphp
   @foreach ($tap_count as $tap)

     @php
     $i = ((($loop->index-1)+$offset)/4)%2;
     $mainindex = $loop->index;
     @endphp
     @if ($loop->index)
     <span class="border rounded tapcell @if($i==1) oddrow @else evenrow @endif" id="stuff">
       <div class="col justify-content-between align-items-center d-flex"><a class='taptext {{ $tap->type ?? "NA" }}' href='/tap/{{ $tap->tap_1}}'> {{ $tap->tap_1}} </a>
         <span class="badge badge-success badge-pill badge-tapcount">{{ $tap->type ?? "NA" }}  |  {{ str_pad($tap->num,4,'    ',STR_PAD_LEFT) }}</span>
       </div>
    </span>
    @endif

    <!-- add subfamilies -->
    @foreach (explode(',',$subfamilies[$tap->tap_1]->subfamilies)  as $subfamily)
      @unless ($subfamily == '-')
        @php $subtap = $tap2_count[$subfamily];
          $offset = $offset + 1;
          $i = (($mainindex-1+$offset)/4)%2;
        @endphp
        <span class="border rounded tapcell @if($i==1) oddrow @else evenrow @endif" id="stuff">
          <div class="col justify-content-between align-items-center d-flex"><a class='taptext {{ $subtap->type ?? "NA" }}' href='/tap/{{ $subtap->tap_2}}'> {{$tap->tap_1}}:{{ $subtap->tap_2}} </a>
            <span class="badge badge-success badge-pill badge-tapcount">{{ $subtap->type ?? "NA" }}  |  {{ str_pad($subtap->num,4,'    ',STR_PAD_LEFT) }}</span>
          </div>
        </span>
      @endunless
    @endforeach
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


