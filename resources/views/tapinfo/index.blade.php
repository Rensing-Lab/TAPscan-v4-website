<!DOCTYPE html>

@extends('layout')

@section('content')

<div class="jumbotron jumbotron-fluid">
  <div class="container">
  <h1 class="display-6">TAP information</h1>
    <p class="lead">This is a table of all TAP info (descriptions, references) covered in TAPscan v4. </p>
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
