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
          @if ($button == "species")
          <p><ul>
             <li>Must a semicolon (<code>;</code>) separated file without a header line </li>
             <li>With 8 columns: <code>lettercode;Kingdom/supergroup;phylum/clade; supergroup2;order;family;scientific name;NCBI TaxID</code></li>
             <li><a target="_blank" href="https://github.com/Rensing-Lab/TAPscan-v4-website/blob/main/_data/import-species/species_v4.csv">Example species file</a></li>
             </ul>
          </p>
          @elseif ($button == "rules")
          <p><ul>
             <li>Must be a semicolon (<code>;</code>) separated file without a header line </li>
             <li>With 3 columns: <code>TAP family;Domain;Rule (should | should not)</code></li>
             <li><a target="_blank" href="https://github.com/Rensing-Lab/TAPscan-v4-website/blob/main/_data/import-rules/rules_v81.txt">Example rules file</a></li>
             </ul>
           </p>
          @elseif ($button == "tap")
          <p><ul>
             <li>Provide the subfamily classification output (<code>*.output.3</code>) from the TAPscan-classify script</li>
             <li>Must be a semicolon (<code>;</code>) separate file, with a header line </li>
             <li>With 5+ columns: <code>GENE_ID;TAP_FAMILY;SUBFAMILY;NUMBER_OF_FAMILIES_FOUND;DOMAIN1;DOMAIN2;..</code></li>
             <li><a target="_blank" href="https://github.com/Rensing-Lab/TAPscan-v4-website/blob/main/_data/import-tap/taps_v4.csv">Example TAPs file</a></li>
             </ul>
          </p>
          @elseif ($button == "tapinfo")
          <p><ul>
             <li>Must be a tab-separated file, with a header line</li>
             <li>With 4 columns: <code>TAP name [TAB] Description [TAB] Reference1,reference2,.. [TAB] Type (TR|TF|PT) </code></li>
             <li><a target="_blank" href="https://github.com/Rensing-Lab/TAPscan-v4-website/blob/main/_data/import-tapinfo/tapinfo_v4.csv">Example TapInfo File</a></li>
             </ul>
          </p>
          @elseif ($button == "domains")
          <p><ul>
             <li>Must be a semicolon (<code>;</code>) separated file without a header line </li>
             <li>with 2 columns: <code> Domain; PFAM ID</code></li>
             <li><a target="_blank" href="https://github.com/Rensing-Lab/TAPscan-v4-website/blob/main/_data/import-domain/domains_v4.csv">Example Domains File</a></li>
             </ul>
          </p>
          @endif
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
