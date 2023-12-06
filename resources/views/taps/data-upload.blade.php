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
    <p>Note: Since there is a performance bottlenoch, the first TAPs migration should be run with the accompanied script. If you want to update TAPs in the future you can use this Upload function.</p>
  </div>
</div>
</div>
</div>

    {{-- <div class="modal fade" id="importmodal" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Products</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="import_product_modal" action="{{ route('species.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Upload File:</strong>
                                    <input type="file" name="file" id="file" class="form-control"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <a class="btn btn-primary" href="#" id="productimportbtn">Import Products</a><a class="btn btn-primary" href="{{ route('species.export') }}" id="productexportbtn">Export Products</a><script>
    
    $('#productimportbtn').on('click', function() {
        $('#importmodal').modal('show');
    });
    </script>

@auth
    <div class="modal fade" id="importmodal" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Products</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="import_product_modal" action="{{ route('rules.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Upload File:</strong>
                                    <input type="file" name="file" id="file" class="form-control"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <a class="btn btn-primary" href="#" id="productimportbtn">Import Products</a><a class="btn btn-primary" href="{{ route('rules.export') }}" id="productexportbtn">Export Products</a><script>
    ...
    $('#productimportbtn').on('click', function() {
        $('#importmodal').modal('show');
    });
    </script>

@endauth

@auth
    <div class="modal fade" id="importmodal" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Products</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="import_product_modal" action="{{ route('tap.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Upload File:</strong>
                                    <input type="file" name="file" id="file" class="form-control"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <a class="btn btn-primary" href="#" id="productimportbtn">Import Products</a><a class="btn btn-primary" href="{{ route('tap.export') }}" id="productexportbtn">Export Products</a><script>
    ...
    $('#productimportbtn').on('click', function() {
        $('#importmodal').modal('show');
    });
    </script>

@endauth --}}


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
