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
    TaxID: {{ $species->taxid }}
  </div>

  <div class="card-body">
    <h5 class="card-title">Name: {{ $species->name }}</h5>
    <!-- <p class="card-text">Graphen, weitere links zu TAPs etc.</p> -->
    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->

    <p>
      This table lists all the TAPs found for species {{$species->name}}.
      Click on a TAP family to view more details, including sequences.
    </p>

    <p>The colour of the TAP name corresponds to the TAP class:
      <span style="background-color:#317b22; color: #ffffff; font-weight: bolder">
        <span class="TF">TF</span>, <span class="TR">TR</span> and <span class="PT">PT</span>
      </span>
      <br/>
      and is shown behind the TAP name, together with the species count:
      <span class="badge badge-success badge-pill badge-tapcount"> TF | 42 </span>
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
  <div class="row row-cols-5">
    @foreach ($tap_count as $tap => $value)
      @php
      $i = (($loop->index-1)/5)%2;
      @endphp

      @if ($loop->index)
        <span class="border rounded @if($i==1) oddrow @else evenrow @endif {{ $tap_info->where('tap',$tap)->first()->type ?? 'NA'}}" id="stuff">
 	   <div class="col justify-content-between align-items-center d-flex">
             <a class="{{ $tap_info->where('tap',$tap)->first()->type ?? 'NA'}}" href='/species/{{ $id }}/tap/{{ $tap }}'> {{ $tap }} </a>
             <span class="badge badge-success badge-pill badge-tapcount"> {{ $tap_info->where('tap',$tap)->first()->type ?? "NA" }} | {{ $value }} </span>
           </div>
	 </span>
       @endif
    @endforeach
  </div>
</div>


@endsection
