<!DOCTYPE html>

@extends('layout')

@section('content')

{{-- @foreach ($tap_show as $tap)
    <p>This is tap {{ $tap->species_id }}</p>
@endforeach --}}

<div class="container">
  <div class="row">
  <div class="jumbotron jumbotron-fluid">
    <div class="container">
    <h1 class="display-6">Family: {{$id}}</h1>
    <p class="lead">Bienz (2006): 	PHD proteins seem to be found universally in the nucleus, and their functions tend to lie in the control of chromatin or transcription. Increasing evidence indicates that PHD fingers bind to specific nuclear protein partners, for which they apparently use their loop 2 surface. Perhaps each PHD finger has its own cognate nuclear ligand, much like RING fingers have their cognate E2 ligases. No doubt the list of specific PHD finger ligands will grow, and the set of these ligands is likely to reveal whether PHD fingers have a common function in the nucleus.</p>
    <hr class="my-1">
    <p>References:<br>

1) 	Bienz, M. 2006. The PHD finger, a nuclear protein-interaction domain. Trends Biochem. Sci. 31(1):35-40 PubMed<br>
2) 	Lang, D; Weiche, B; Timmerhaus, G; Richardt, S; Riano-Pachon, DM; Correa, LG; Reski, R; Mueller-Roeber, B; Rensing, SA. 2010. Genome-wide phylogenetic comparative analysis of plant transcriptional regulation: a timeline of loss, gain, expansion, and correlation with complexity. Genome Biol Evol. 2: 488-503 PubMed.</p>
  </div>
</div>
</div>

  <div class="row">
    <div class="col-6">
      <table class="table table-sm table-bordered">
  <tbody>
    <tr>
      <td>Name:</td>
      <td>{{$id}}</td>
    </tr>
    <tr>
      <td>Class:</td>
      <td>TF/TR/PT</td>
    </tr>
    <tr>
      <td>Number of species containing the TAP:</td>
      <td>{{$tap_species_number}}</td>
    </tr>
    <tr>
      <td>Number of available proteins:</td>
      <td>KOMMT AUCH NOCH BALD</td>
    </tr>
  </tbody>
</table>
    </div>

    <div class="col-6">
      Domain rules:
      <br>
      @foreach ($tap_rules as $rules)
          @if ($rules->rule === "should")
            <button type="button" class="btn btn-outline-success">{{$rules->tap_2}}</button>
          @endif
          @if ($rules->rule === "should not")
            <button type="button" class="btn btn-outline-danger">{{$rules->tap_2}}</button>
          @endif
      @endforeach
    </div>
  </div>

  {{-- @foreach ($tap_distribution as $distribution)
    {{$distribution->name}}
    {{$distribution->test}}
  @endforeach --}}

<img src="{{ asset('img/temp_tree.png') }}" alt="description of myimage">


  <div class="row">
    TAP distribution:
    <table class="table table-sm table-bordered">
      <thead>
        <tr>
  <th scope="col">Minimum</th>
  <th scope="col">Maximum</th>
  <th scope="col">Average</th>
  <th scope="col">Median</th>
  <th scope="col">Standard deviation</th>
</tr>
      </thead>
<tbody>
  <tr>
    <td>{{$tap_distribution->min('test')}}</td>
    <td>{{$tap_distribution->max('test')}}</td>
    <td>{{$tap_distribution->avg('test')}}</td>
    <td>{{$tap_distribution->median('test')}}</td>
    <td>{{$tap_distribution->pluck('test')}}</td>
  </tr>
</tbody>
</table>
  </div>
</div>

@endsection
