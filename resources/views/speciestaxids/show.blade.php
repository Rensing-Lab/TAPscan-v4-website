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
    Name: {{ $species->name }}
  </div>

  <div class="card-body">
    <h5 class="card-title">TaxID: {{ $species->taxid }}</h5>
    <!-- <p class="card-text">Graphen, weitere links zu TAPs etc.</p> -->
    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
  </div>
</div>

<br>

        <div class="container">
          <div class="row row-cols-6">
        @foreach ($tap_count as $tap => $value)
              @if ($loop->index)
                <span class="border rounded" id="stuff">
                 <div class="col justify-content-between align-items-center d-flex"><a href='/species/{{ $id }}/tap/{{ $tap }}'> {{ $tap }} </a>
                 <span class="badge badge-success badge-pill">{{ $value }}</span>
                 </div>
                 </span>
              @endif
        @endforeach
          </div>
        </div>


@endsection
