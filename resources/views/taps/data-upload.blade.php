<!DOCTYPE html>

@extends('layout')

@section('content')

<div class="container">
  <div class="row">
  <div class="jumbotron jumbotron-fluid">
    <div class="container">
    <h1 class="display-6">Upload Data to Databases</h1>
    <p class="lead">Please fill the database in the correct order.</p>
    <hr class="my-1">
    <p>TODO: info on file formats</p>
  </div>
</div>
</div>
</div>
<br>

<!-- Buttons -->
@auth
<div class="container">
  <div class="row row-cols-1">

    @foreach ($download_buttons as $button)
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#{{$button}}Modal">Import {{$button}}</button>
      <br>
      <br>
    @endforeach

  </div>

  @foreach ($download_buttons as $button)
    <div class="modal fade" id="{{$button}}Modal" tabindex="-1" aria-labelledby="{{$button}}ModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="TAPsModalLabel">Import {{$button}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form id="import_{{$button}}_modal" action="{{ route($button.'.import') }}" method="POST" enctype="multipart/form-data">
              @csrf
          <div class="modal-body">
            <input type="file" name="file" id="{{$button}}_file" class="form-control" multiple/>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Import</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
          </form>

        </div>
      </div>
    </div>
  @endforeach

</div>
@endauth


</div>


{{-- @include('footer') --}}

@endsection
