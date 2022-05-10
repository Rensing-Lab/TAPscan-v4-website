<!DOCTYPE html>

@extends('layout')

@section('content')

<div class="container">
  <div class="row">
  <div class="jumbotron jumbotron-fluid">
    <div class="container">
    <h1 class="display-6">TAPscan - Families</h1>
    <p class="lead">This is a list of all TAPs covered by the TAPscan web page. Clicking them will lead you to a list of species in which these TAP families occur. The number of proteins containing the respective TAP is written in brackets after its name.</p>
    <hr class="my-1">
    <p>The colour code corresponds to TAP classes:
Transcriptional regulation is carried out by transcription associated proteins (TAPs), comprising transcription factors (TFs, binding in sequence-specific manner to cis-regulatory elements to enhance or repress transcription), transcriptional regulators (TRs, acting as part of the transcription core complex, via unspecific binding, protein-protein interaction or chromatin modification) and putative TAPs (PTs), the role of which needs to be determined. </p>
  </div>
</div>
</div>
</div>

    {{-- <h1>TAP families</h1>
    <p style="text-align: justify;">This is a list of all TAPs covered by the TAPscan web page. Clicking them will lead you to a list of species
    in which these TAP families occur. The number of proteins containing the respective TAP is written in brackets after its name.</p>
    <br>
    <p style="text-align: right">The colour code corresponds to TAP classes:</p>
    <table>
        <tr>
            <td style="text-align: justify; padding-right:10px;">
                Transcriptional regulation is carried out by transcription associated proteins (<b>TAP</b>s), comprising transcription factors
                (<b>TF</b>s, binding in sequence-specific manner to cis-regulatory elements to enhance or repress transcription),
                transcriptional regulators (<b>TR</b>s, acting as part of the transcription core complex, via unspecific binding,
                protein-protein interaction or chromatin modification) and putative TAPs (<b>PT</b>s), the role of which needs to be determined.
            </td>
            <td>
                <div style="display:inline-block; background-color: #006600; margin-left: 2px; margin-top: 2px; margin-right: 2px; padding: 6px; float: right; white-space: nowrap;">
                <div class="colour-box green-b"></div><span class="green"><b> transcription factor (TF)</b></span>
                <br>
                <div class="colour-box orange-b"></div> <span class="orange"><b> transcriptional regulator (TR)</b></span>
                <br>
                <div class="colour-box yellow-b"></div><span class="yellow"><b> putative TAP (PT)</b></span>
                </div>
            </td>
    </table> --}}

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
    ...
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


<br>

<!-- Buttons -->
@auth
<div class="container">
  <div class="row row-cols-3">

    @foreach ($download_buttons as $button)
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#{{$button}}Modal">Import {{$button}}</button>
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





    {{-- @foreach ($tap_count as $tap)
      @if ($loop->first)
        <ul class="list-group list-group-horizontal align-content-around flex-wrap">
      @endif
      @if ($loop->iteration % 6 == 0)
      </ul><ul class="list-group list-group-horizontal align-content-around flex-wrap">
      @endif
        <li class="w-15 p-2 list-group-item justify-content-between align-items-center flex-fill">{{ $tap->tap_1}}
        <span class="badge badge-success badge-pill">{{ $tap->num}}</span>
        </li>
    @endforeach --}}

    {{-- @foreach ($tap_count as $tap)
      @if ($loop->first)
        <ul class="list-group list-group-horizontal flex-wrap">
      @endif
        <li class="list-group-item align-items-center text-center">{{ $tap->tap_1}}
        <span class="badge badge-success badge-pill">{{ $tap->num}}</span>
        </li>
        @if ($loop->last)
        </ul>
        @endif
    @endforeach --}}

</div>





{{--
  @php
   $count_z = 0;
   $table_rows = 6;
   $class_color = "";
  @endphp

  @foreach ($family as $row)

    @php
    if ($row->class_id === 1) {
       $color = "green tablelink";
    }elseif ($row->class_id === 2) {
       $color = "orange tablelink";
    }else{
       $color = "yellow tablelink";
    }
    @endphp

    @if ($count_z%$table_rows === 0)
      <tr>
        <td class="sameHeight">
          <b><a class="{{$color}}">{{ $row->name }} ({{ $row->num_proteins}})</a></b>
        </td>
    @elseif ($count_z%$table_rows > 0)
      <td class="sameHeight">
        <b><a class="{{$color}}">{{ $row->name }} ({{ $row->num_proteins}})</a></b>
      </td>
    @elseif ($count_z%$table_rows === 0)
      </tr>
    @endif

    @php
      $count_z === $count_z++;
    @endphp

  @endforeach --}}




{{-- @if (count($records) === 1)
    I have one record!
@elseif (count($records) > 1)
    I have multiple records!
@else
    I don't have any records!
@endif --}}

{{-- @include('footer') --}}

@endsection
