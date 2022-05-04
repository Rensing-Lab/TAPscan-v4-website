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

<div class="card text-center">
  <div class="card-header">
     NEWS
  </div>
  <div class="card-body">
    <h5 class="card-title">{{ $news_data->name }}</h5>
    <p class="card-text">{{ $news_data->content }}</p>
  </div>
  <div class="card-footer text-muted">
    {{$news_data->created_at}}
  </div>
</div>



@endsection
