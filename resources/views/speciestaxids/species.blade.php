<!DOCTYPE html>

@extends('layout')

@section('content')

  <div class="container">
    <div class="row row-cols-6">
  @foreach ($tap_count as $tap)
        @if ($loop->index)
          <span class="border rounded" id="stuff">
           <div class="col justify-content-between align-items-center d-flex"><a href='/tap/{{ $tap->tap_1}}'> {{ $tap->tap_1}} </a>
          <span class="badge badge-warning badge-pill">2</span>
           <span class="badge badge-success badge-pill">{{ $tap->num}}</span>
           </div>
           </span>
        @endif
  @endforeach
    </div>
  </div>

@endsection
