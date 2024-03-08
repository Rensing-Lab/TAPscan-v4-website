<!DOCTYPE html>

@extends('layout')

@section('content')

  <div class="jumbotron jumbotron-fluid">
    <div class="container">
    <h1 class="display-6">TAPscan - Species View</h1>
    <p class="lead">This is a list of all species covered by the TAPscan web page v4.
    </br></br>
    Below you can explore the species in tree form. A <a href="/species-list">table</a> listing all species is also available.</p>
    <hr class="my-1">
    <h6> What are TAPs?</h6>
    <p>Transcriptional regulation is carried out by transcription associated proteins (TAPs), comprising <i>transcription factors</i>
       (TFs, binding in sequence-specific manner to cis-regulatory elements to enhance or repress transcription),
       <i>transcriptional regulators</i> (TRs, acting as part of the transcription core complex, via unspecific binding, protein-protein interaction or chromatin modification)
       and <i>putative TAPs</i> (PTs), the role of which needs to be determined.
    </p>
  </div>
</div>

  <!-- 3 setup a container element -->

  <input type="text" id="jstree_q" value="" class="input" style="margin:0em auto 1em auto; display:left; padding:4px; border-radius:4px; border:1px solid silver;">
  <div id="jstree">

  </div>

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
  "plugins" : ["contextmenu","wholerow","search","sort"]
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
      if(!isNaN(data.selected))
      {
         window.open('/species/' + data.selected, '_self');
         // location.href='/species/' + data.selected;
      }else{
         //do some thing if it's NOT a number
      }
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
