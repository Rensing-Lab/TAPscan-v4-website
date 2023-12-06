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
    <h1 class="display-6">TAP Family: {{$id}}</h1>
    <p class="lead">{{ $tap_info[0]->text }}</p>
    <hr class="my-1">
    <p>References:<br>

    {!! $tap_info[0]->reference !!}

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
      <td>{{ $tap_info[0]->type }}</td>
    </tr>
    <tr>
      <td>Number of species containing the TAP:</td>
      <td>{{$tap_species_number}}</td>
    </tr>
    <tr>
      <td>Number of available proteins:</td>
      <td>{{ $tap_count }}</td>
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


  <div class="row">
    TAP distribution:
    <table class="table table-sm table-bordered">
      <thead>
        <tr>
  <th scope="col">Minimum</th>
  <th scope="col">Maximum</th>
  <th scope="col">Average</th>
  <th scope="col">Median</th>
</tr>
      </thead>
<tbody>
  <tr>
    <td>{{$tap_distribution->min('test')}}</td>
    <td>{{$tap_distribution->max('test')}}</td>
    <td>{{$tap_distribution->avg('test')}}</td>
    <td>{{$tap_distribution->median('test')}}</td>
  </tr>
</tbody>
</table>
  </div>
</div>

@endsection
