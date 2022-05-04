<!DOCTYPE html>

@extends('layout')

@section('content')

<div class="row">
  <div class="container" id="barPlot"></div>
</div>
<div class="row">
  <div class="container" id="piePlot"></div>
</div>
<div class="row">
  <div class="container" id="tree_container">
    <script>



    </script>

  </div>
</div>


{{-- layout is borked because of this include --}}
  @include('visualization.hehe')




  <script src="{{ asset('js/plotly.js')}}"></script>
  {{-- <script src="{{ asset('js/pie_chart.js') }}" defer></script> --}}
  {{-- <div class="container">
  <div class="row row-cols-2">
      <div class="container" id="barPlot"></div>
      <div class="container" id="piePlot"></div>
  </div>
  </div> --}}

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
