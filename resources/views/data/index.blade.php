<!DOCTYPE html>

@extends('layout')

@section('content')

<script src="{{ asset('js/plotly.js')}}"></script>
<style>
.btn-square-md {
width: 100px !important;
max-width: 100% !important;
max-height: 100% !important;
height: 100px !important;
text-align: center;
padding: 0px;
font-size:12px;
}
</style>


<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-6">TAPscan - Data</h1>
    <p class="lead">Here you can quickly access all data currently available in TAPscan in table format.
    </br></br>
    <hr class="my-1">
  </div>
</div>

@auth
<h3>Admin Area</h3>

<p>Below you can perform various admin activities, such as uploading data from files, or editing existing database entries.</p>

<a href="/data-upload"><button type="button" class="btn btn-secondary btn-square-md">Data Upload</button></a>
<a href="/species/table"><button type="button" class="btn btn-primary btn-square-md">Species</button></a>
<a href="/rules/table"><button type="button" class="btn btn-primary btn-square-md">Rules</button></a>
<a href="/taps/table"><button type="button" class="btn btn-primary btn-square-md">TAPs</button></a>
<a href="/tapinfo/table"><button type="button" class="btn btn-primary btn-square-md">Tap Information</button></a>
<a href="/domain/table"><button type="button" class="btn btn-primary btn-square-md">Domains</button></a>
<a href="/news/table"><button type="button" class="btn btn-primary btn-square-md">News</button></a>
<a href="http://tapscan.plantcode.cup.uni-freiburg.de:8001/tapscan.plantcode.cup.uni-freiburg.de">
  <button type="button" class="btn btn-secondary btn-square-md">Website Metrics</button>
</a>
<br></br>
@endauth

<h3>View Data</h3>

<a href="/species-list"><button type="button" class="btn btn-primary btn-square-md">Species</button></a>
<a href="/taps"><button type="button" class="btn btn-primary btn-square-md">TAPs</button></a>
<a href="/tapinfo"><button type="button" class="btn btn-primary btn-square-md">TAP information</button></a>

<a href="/rules"><button type="button" class="btn btn-primary btn-square-md">Domain Rules</button></a>
<a href="/domain"><button type="button" class="btn btn-primary btn-square-md">Domains</button></a>

<br></br>
<h3>Visualisations</h3>
<div class="row">
  <div class="container" id="barPlot"></div>
</div>
<div class="row">
  <div class="container" id="piePlot" height="100%"></div>
</div>
  <script>

  var tap_data = @json($circle_viz);
  const labels_data = [];
  const values_data = [];
  tap_data.forEach(element => {
      labels_data.push(element.tap_1),
      values_data.push(element.num)

  });

  var data1 = [{

    y: values_data,
    x: labels_data,

    type: 'bar'

  }];

  var data2 = [{

    values: values_data,
    labels: labels_data,

    type: 'pie'

  }];

  var layout = {
      plot_bgcolor:"#FFF3",
      paper_bgcolor:"#FFF3"
};

  // jsonData.forEach(element => {
  //     result[element['color']] = element['value']
  // });
  // jsonString = JSON.stringify(result)

  console.log(labels_data);
  // var layout = {
  //
  //   height: 300
  //
  // };


  // Plotly.newPlot('myDiv', data,layout);
  Plotly.newPlot('barPlot', data1, layout);
  Plotly.newPlot('piePlot', data2, layout);



  </script>


  </div>



@endsection
