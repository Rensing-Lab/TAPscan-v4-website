<!DOCTYPE html>

@extends('layout')

@section('content')
<style>
table {
    table-layout: fixed;
    width: 100%;
}

table td {
    word-wrap: break-word;         /* All browsers since IE 5.5+ */
    overflow-wrap: break-word;     /* Renamed property in CSS3 draft spec */
}
</style>
  <div class="container-fluid">
      <h1>Table of Species <i>{{ $species_full_name }}</i> with TAP <b>{{ $tap_name }}</b></h1>
      <br>
      <table class="table table-bordered data-table" width="20px">
          <thead>
              <tr>
                  <th>No</th>
                  <th>TAP ID</th>
                  <th>TAP Family</th>
                  <th>Subfamily</th>
                  <th>Sequence</th>
                  <th>Links</th>
              </tr>
          </thead>
          <tbody>
          </tbody>
      </table>
  </div>

     <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
     <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
     <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">

  <script type="text/javascript">
    $(function () {

      var table = $('.data-table').removeAttr('width').DataTable({
          processing: true,
          serverSide: true,
          searching: true,
          ajax: {
            url: "{{ route('taps.subtapspecies', ['species_id' => $species_id, 'tap_name' => $tap_name]) }}",
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Problem getting sequences, please check the fasta file for this species.");
            }
          },
          dom: 'Blfrtip',
              buttons: [
                   {
                       extend: 'csv',
                   },
                   {
                       extend: 'excel',
                   }
              ],
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex', width:'1%'},
              {data: 'id', name: 'id', searchable: true, width: '8%'},
              {data: 'tap_1', name: 'tap_1', searchable: true, width: '10%'},
              {data: 'tap_2', name: 'tap_2', searchable: true, width: '8%'},
              {data: 'sequence', name: 'sequence', searchable: true, width: '74%'},
              {data: 'plaza', name: 'plaza', searchable: true, width: '4%',
              render: function ( data, type, row, meta ) {
                if (data[0]==undefined) {return "";}
                return '<a href="https://bioinformatics.psb.ugent.be/plaza/genes/redirect_gene/'+data[0]+'/'+data[1]+'"> PLAZA </a>';
              }},


              // {data: 'email', name: 'email'},
              // {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
          search: {
  "regex": true
},
      });

    });
  </script>

@endsection
