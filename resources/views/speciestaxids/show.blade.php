<!DOCTYPE html>

@extends('layout')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Error!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li></li>
                @endforeach
            </ul>
        </div>
    @endif


<div class="card">
  <div class="card-header">
    <h5 class="card-title">Name: {{ $species->name }} ({{$species->lettercode }})</h5>
    NCBI TaxID: <a target="_blank" href="https://www.ncbi.nlm.nih.gov/Taxonomy/Browser/wwwtax.cgi?id={{ $species->taxid }}">{{ $species->taxid }} </a>
  </div>

  <div class="card-body">
        <!-- <p class="card-text">Graphen, weitere links zu TAPs etc.</p> -->
    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->

    <p>
      This table lists all the TAPs found for species <i>{{$species->name}}</i>.


      Click on a TAP family to view more details, including sequences.
    </p>


    <p>The colour of the TAP family name corresponds to the TAP class:
      <span style="background-color:#317b22; color: #ffffff; font-weight: bolder">
        <span class="TF">TF</span>, <span class="TR">TR</span> and <span class="PT">PT</span>
      </span>
      <br/>
      and is shown behind the TAP name, together with the TAP count:
      <span class="badge badge-success badge-pill badge-tapcount"> TF | 42 </span><br>
      Subfamilies are also included in this table, and named like: <b><code>Family:Subfamily</code></b>
    </p>
  </div>
</div>

<br>

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
    @foreach ($tap_count as $tap => $value)
      @php
      $i = (($loop->index-1+$offset)/4)%2;
      $mainindex = $loop->index;
      @endphp

      <!--{ {$species_families[$tap][0]->tap_1}}-->

      @if ($loop->index)
        <span class="border rounded @if($i==1) oddrow @else evenrow @endif {{ $tap_info->where('tap',$tap)->first()->type ?? 'NA'}}" id="stuff">
 	      <div class="col justify-content-between align-items-center d-flex">
            <a class="{{ $tap_info->where('tap',$tap)->first()->type ?? 'NA'}}" href='/species/{{ $id }}/subtap/{{ $tap }}'> {{ $tap }} </a>
            <span class="badge badge-success badge-pill badge-tapcount"> {{ $tap_info->where('tap',$tap)->first()->type ?? "NA" }} | {{ $value }} </span>
          </div>
	    </span>

        <!-- add subfamilies -->
        @foreach (explode(',',$subfamilies[$tap]->subfamilies)  as $subfamily)
          @unless ($subfamily == '-')
            @php $subtap = $tap2_count[$subfamily];
              $offset = $offset + 1;
              $i = (($mainindex-1+$offset)/4)%2;
            @endphp

          <span class="border rounded @if($i==1) oddrow @else evenrow @endif {{ $tap_info->where('tap',$subfamily)->first()->type ?? 'NA'}}" id="stuff">
 	      <div class="col justify-content-between align-items-center d-flex">
            <a class="{{ $tap_info->where('tap',$subfamily)->first()->type ?? 'NA'}}" href='/species/{{ $id }}/tap/{{ $subfamily }}'> {{$tap}}:{{ $subfamily }} </a>
            <span class="badge badge-success badge-pill badge-tapcount"> {{ $tap_info->where('tap',$subfamily)->first()->type ?? "NA" }} | {{ $tap2_count[$subfamily] }} </span>
          </div>
	    </span>

          @endunless
        @endforeach
      @endif
    @endforeach
  </div>
</div>


@endsection
