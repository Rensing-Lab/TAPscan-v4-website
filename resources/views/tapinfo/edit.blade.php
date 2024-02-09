<!DOCTYPE html>

@extends('layout')
{ { dd(get_defined_vars()['__data']) }}
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit TAP Information {{ $tapinfo_data->tap}} </h2>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Error!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li></li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tapinfo.update', $tapinfo_data->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>TAP (Sub)Family Name:</strong>
                    <input type="text" name="tap" value="{{ $tapinfo_data->tap }}" class="form-control" placeholder="Name">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>TAP Type (TF,TR or PT):</strong>
                    <input type="text" name="type" value="{{ $tapinfo_data->type }}" class="form-control" placeholder="Name">
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Description:</strong>
                    <label for="exampleFormControlTextarea1"></label>
                    <textarea class="form-control" name="text" id="" rows="3">{{ $tapinfo_data->text }}</textarea>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>References:</strong>
                    <label for="exampleFormControlTextarea1"></label>
                    <textarea class="form-control" name="reference" id="" rows="3">{{ $tapinfo_data->reference }}</textarea>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

    </form>



@endsection
