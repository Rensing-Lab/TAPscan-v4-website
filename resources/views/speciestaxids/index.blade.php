<!DOCTYPE html>

@extends('layout')

@section('content')

  <!-- 3 setup a container element -->

  <input type="text" id="jstree_q" value="" class="input" style="margin:0em auto 1em auto; display:left; padding:4px; border-radius:4px; border:1px solid silver;">
  <div id="jstree">

  </div>
  <button>demo button</button>

  <script>
  $(function () {
    // 6 create an instance when the DOM is ready


    $('#jstree').jstree({
      'core' :
      {
      "themes" : {
      "variant" : "large"
    },
    'data' : {!!  $species_tree  !!}
  },
  "checkbox" : {
    "keep_selected_style" : false
  },
  "plugins" : ["contextmenu","wholerow", "checkbox","search"]
  });

  var to = false;
  $('#jstree_q').keyup(function () {
    if(to) { clearTimeout(to); }
    to = setTimeout(function () {
      var v = $('#jstree_q').val();
      $('#jstree').jstree(true).search(v);
    }, 250);
  });


    // 7 bind to events triggered on the tree
    $('#jstree').on("changed.jstree", function (e, data) {
      console.log(data.selected);
    });
    // $('#jstree').on("select_node.jstree", function (e, data) {
    //   alert("node_id: " + data.node.text);
    //   window.location.href = "/species/" + data.node.text;
    // });
    // 8 interact with the tree - either way is OK
    $('button').on('click', function () {
      $('#jstree').jstree(true).select_node('child_node_1');
      $('#jstree').jstree('select_node', 'child_node_1');
      $.jstree.reference('#jstree').select_node('child_node_1');
    });
    $('#jstree').jstree();
  });
  </script>

@endsection
