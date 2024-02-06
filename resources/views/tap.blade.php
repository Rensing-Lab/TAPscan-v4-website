<!DOCTYPE html>

@extends('layout')

@section('content')

{{-- @foreach ($tap_show as $tap)
    <p>This is tap {{ $tap->species_id }}</p>
@endforeach --}}

<div class="container">
  <div class="row">
    <div class="jumbotron jumbotron-fluid">
      <div class="container">
        <h1 class="display-6">TAP Family: {{$id}}</h1>
        <p class="lead">{{ $tap_info[0]->text ?? "Description missing"}}</p>
        <hr class="my-1">
        <p>References:<br>

        @isset($tap_info[0])
        @if ($tap_info[0]->reference != "")
        @foreach(explode(',"', $tap_info[0]->reference) as $reference)
          <p>{!! Markdown::parse(preg_replace('/(http[\w\.\-\/:_]*)\"?$/', '[\1](\1)', $reference)) !!} </p>
        @endforeach
        @endif
        @endisset


      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-6">
      <table class="table table-sm table-bordered" style="height: 100%">
        <tbody>
          <tr>
            <td>Name:</td>
            <td>{{ $id }}</td>
          </tr>
          <tr>
            <td>Class:</td>
            <td>{{ $tap_info[0]->type ?? "Unknown" }}</td>
          </tr>
          <tr>
            <td>Number of species containing the TAP:</td>
            <td>{{ $tap_species_number }}</td>
          </tr>
          <tr>
            <td>Number of available proteins:</td>
            <td>{{ $tap_count }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="col-6">
      Domain rules:
      <?php $pfam=null ?>
      @foreach ($tap_rules as $rules)
        <?php $pfam=null ?>
        @foreach ($domain_info as $domain)
	      @if ($domain->name === $rules->tap_2)
            @if (str_starts_with($domain->pfam,"PF"))
	        <?php $pfam = $domain->pfam; ?>
            @endif
          @endif
	@endforeach

        <a @if($pfam)target="_blank" href="https://www.ebi.ac.uk/interpro/entry/pfam/{{ $pfam }}"@else href="/domain" @endif>
        @if ($rules->rule === "should")
           <button type="button" @if($pfam)class="btn btn-success"@else class="btn btn-outline-success" @endif>{{$rules->tap_2}}</button>
        @endif
        @if ($rules->rule === "should not")
            <button type="button" @if($pfam)class="btn btn-danger" @else class="btn btn-outline-danger"@endif>{{$rules->tap_2}}</button>
	@endif
	</a>
      @endforeach

      <br/><br/>
      TAP distribution:
      <br/>
      <table class="table table-sm table-bordered">
        <thead>
          <tr>
            <th scope="col">Minimum</th>
            <th scope="col">Maximum</th>
            <th scope="col">Average</th>
            <th scope="col">Median</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{$tap_distribution->min('test')}}</td>
            <td>{{$tap_distribution->max('test')}}</td>
            <td>{{$tap_distribution->avg('test')}}</td>
            <td>{{$tap_distribution->median('test')}}</td>
          </tr>
        </tbody>
      </table>

      {{-- @foreach ($tap_distribution as $distribution)
        {{$distribution->name}}
        {{$distribution->test}}
      @endforeach --}}

    </div>
  </div>
  <br/>
  Download phylogenetic tree (Newick format):
  <br/>
  @php $tree_id = str_replace('/', '_', $id); @endphp
  @if (Storage::disk('public')->exists("trees/quicktree_reducedAlignment_".$tree_id.".tre"))
  <a href="/storage/trees/quicktree_reducedAlignment_{{$tree_id}}.tre" download><button type="button" class="btn btn-info">NJ-tree</button></a>
  @elseif (Storage::disk('public')->exists("trees/quicktree_alignment_".$tree_id.".tre"))
  <a href="/storage/trees/quicktree_alignment_{{$tree_id}}.tre" download><button type="button" class="btn btn-info">NJ-tree</button></a>
  @endif

  @if (Storage::disk('public')->exists("trees/MAFFT_reducedAlignment_trim.fasta_".$tree_id.".treefile"))
  <a href="/storage/trees/MAFFT_reducedAlignment_trim.fasta_{{$tree_id}}.treefile" download><button type="button" class="btn btn-info">ML-tree</button></a>
  @elseif (Storage::disk('public')->exists("trees/MAFFT_alignment_trim.fasta_".$tree_id.".treefile"))
  <a href="/storage/trees/MAFFT_alignment_trim.fasta_{{$tree_id}}.treefile" download><button type="button" class="btn btn-info">ML-tree</button></a>
  @endif

  <br/>
  @if (Storage::disk('public')->exists("trees/svgs/quicktree_reducedAlignment_".$tree_id.".tre.svg"))
  <details>
    <summary>View NJ Tree</summary>
      <object data="/storage/trees/svgs/quicktree_reducedAlignment_{{$tree_id}}.tre.svg" alt="Phylogenetic tree image for {{$id}}"/>
  </details>
  @elseif (Storage::disk('public')->exists("trees/svgs/quicktree_alignment_".$tree_id.".tre.svg"))
  <details>
    <summary>View NJ Tree</summary>
      <object data="/storage/trees/svgs/quicktree_alignment_{{$tree_id}}.tre.svg" alt="Phylogenetic tree image for {{$id}}"/>
  </details>
  @endif

  @if (Storage::disk('public')->exists("trees/svgs/MAFFT_reducedAlignment_trim.fasta_".$tree_id.".treefile.svg"))
  <details>
    <summary>View ML Tree</summary>
      <object data="/storage/trees/svgs/MAFFT_reducedAlignment_trim.fasta_{{$tree_id}}.treefile.svg" alt="Phylogenetic tree image for {{$id}}"/>
  </details>
  @elseif (Storage::disk('public')->exists("trees/svgs/MAFFT_alignment_trim.fasta_".$tree_id.".treefile.svg"))
  <details>
    <summary>View ML Tree</summary>
      <object data="/storage/trees/svgs/MAFFT_alignment_trim.fasta_{{$tree_id}}.treefile.svg" alt="Phylogenetic tree image for {{$id}}"/>
  </details>

  @endif

</div>

@endsection
