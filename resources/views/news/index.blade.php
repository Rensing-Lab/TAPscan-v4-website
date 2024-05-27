<!DOCTYPE html>

@extends('layout')

@section('content')


  @foreach ($news as $new)

    <div class="card text-center">
        @if ($loop->first)
          <div class="card-header">
         CURRENT NEWS
         </div>
       @endif
      <div class="card-body">
        <h5 class="card-title">{{$new->name}}</h5>
        <p class="card-text">{{ Illuminate\Mail\Markdown::parse($new->content)}}</p>
      </div>
      <div class="card-footer text-muted">
        {{$new->updated_at}}
      </div>
    </div>
    <br>
  @endforeach

@endsection
