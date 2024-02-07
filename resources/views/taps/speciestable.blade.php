@extends('layout')

@section('content')

<div class="container">
  <div class="row">
    <div class="jumbotron jumbotron-fluid">
      <div class="container">
        <h1 class="display-6">Species containing TAP: {{$id}}</h1>
        <p class="lead"> Below is the table of species in which TAP {{$id}} was found. Click on a TaxID to go to the corresponding NCBI page</p>
        <hr class="my-1">
      </div>
    </div>
  </div>
  <div class="row">

  <input type="text" id="search" onkeyup="searchTable()" placeholder="Search..">

  <table id="speciesTable" class="table-sm table-bordered" style="width: 100%">
  <tr>
    <th>Lettercode</th>
    <th>Species Name</th>
    <th>NCBI TaxID</th>
  </tr>
  @foreach ($species_info as $s)
  <tr>
     <td>{{$s->lettercode}}</td>
     <td><a href="/species/{{$s->id}}"> {{$s->name}} </a></td>
     <td><a href="https://www.ncbi.nlm.nih.gov/Taxonomy/Browser/wwwtax.cgi?id={{$s->taxid}}">{{$s->taxid}}</a></td>
  </tr>
  @endforeach
</table>

<script>
function searchTable() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("search");
  filter = input.value.toUpperCase();
  table = document.getElementById("speciesTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>
<style>
#search {
  background-image: url('/css/searchicon.png'); /* Add a search icon to input */
  background-position: 10px 12px; /* Position the search icon */
  background-repeat: no-repeat; /* Do not repeat the icon image */
  width: 100%; /* Full-width */
  font-size: 16px; /* Increase font-size */
  padding: 12px 20px 12px 40px; /* Add some padding */
  border: 1px solid #ddd; /* Add a grey border */
  margin-bottom: 12px; /* Add some space below the input */
}

#speciesTable {
  border-collapse: collapse; /* Collapse borders */
  width: 100%; /* Full-width */
  border: 1px solid #ddd; /* Add a grey border */
  font-size: 18px; /* Increase font-size */
}

#speciesTable th, #speciesTable td {
  text-align: left; /* Left-align text */
  padding: 12px; /* Add padding */
}

#speciesTable tr {
  /* Add a bottom border to all table rows */
  border-bottom: 1px solid #ddd;
}

#speciesTable tr.header, #speciesTable tr:hover {
  /* Add a grey background color to the table header and on hover */
  background-color: #f1f1f1;
}
</style>
  </div>
</div>

@endsection
