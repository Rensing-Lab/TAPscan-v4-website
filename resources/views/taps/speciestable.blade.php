@extends('layout')

@section('content')

<div class="container">
  <div class="row">
    <div class="jumbotron jumbotron-fluid">
      <div class="container">
        <h1 class="display-6">Species containing TAP: {{$id}}</h1>
        <p class="lead"> Below is the table of species in which TAP {{$id}} was found. Click on a TaxID to go to the corresponding NCBI page</p>
        <hr class="my-1">
      </div>
    </div>
  </div>
  <div class="row">

  <table class="table-sm table-bordered" style="width: 100%">
  <tr>
    <th>Lettercode</th>
    <th>Species Name</th>
    <th>NCBI TaxID</th>
  </tr>
  @foreach ($species_info as $s)
  <tr>
     <td>{{$s->lettercode}}</td>
     <td>{{$s->name}}</td>
     <td><a href="https://www.ncbi.nlm.nih.gov/Taxonomy/Browser/wwwtax.cgi?id={{$s->taxid}}">{{$s->taxid}}</a></td>
  </tr>
  @endforeach
</table>

  </div>
</div>

@endsection
