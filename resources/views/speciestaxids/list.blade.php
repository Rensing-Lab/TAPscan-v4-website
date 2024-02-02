<!DOCTYPE html>

@extends('layout')

@section('content')

<div class="jumbotron jumbotron-fluid">
  <div class="container">
  <h1 class="display-6">Species Table</h1>
    <p class="lead">This is a table of all species included in TAPscan v4. Protein names (e.g. in the phylogenetic trees) are extended by a (typically five) letter code abbreviating the species, e.g. ORYSA = ORYza SAtiva. These lettercodes are listed in the table below. </p>
    <hr class="my-1">
    </p>
  </div>
</div>

<div class="container">
  <div class="row">
    {{ $table }}
  </div>
</div>

@endsection
