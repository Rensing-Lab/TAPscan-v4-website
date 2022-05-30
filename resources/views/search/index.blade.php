<!DOCTYPE html>

@extends('layout')

@section('content')

      <div class="row justify-content-center">
          <div class="col-md-12 d-flex justify-content-center">
  		          <div class="card" style="width: 40rem;">
                      <div class="card-header"><b>{{ $searchResults->count() }} results found for "{{ request('query') }}"</b></div>

                      <div class="card-body">

                          @foreach($searchResults->groupByType() as $type => $modelSearchResults)
                              <h2>{{ ucfirst($type) }}</h2>

                              @foreach($modelSearchResults as $searchResult)
                                @if ($type == "Species_tax_ids")
                                  <ul>
                                      <li><a href="/species/{{ $searchResult->searchable->code }}">{{ $searchResult->title }}</a></li>
                                  </ul>
                                @else
                                  <ul>
                                      <li><a href="/tap/{{ $searchResult->searchable->tap_1 }}">{{ $searchResult->title }}</a></li>
                                  </ul>
                                @endif
                              @endforeach
                          @endforeach

                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>

@endsection
