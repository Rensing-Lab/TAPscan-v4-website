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
  <div class="container">
      <h1>Table of Species PLEASE IMPORT ID</h1>
      <table class="table table-bordered data-table" width="20px">
          <thead>
              <tr>
                  <th>No</th>
                  <th>ID</th>
                  <th>Sequence</th>
              </tr>
          </thead>
          <tbody>
          </tbody>
      </table>
  </div>

  <script type="text/javascript">
    $(function () {

      var table = $('.data-table').removeAttr('width').DataTable({
          processing: true,
          serverSide: true,
          searching: true,
          ajax: "{{ route('taps.show', ['tap' => $tap ]) }}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex', width:'1%'},
              {data: 'id', name: 'id', searchable: true},
              {data: 'sequence', name: 'sequence', searchable: true, width: '75%'},


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
