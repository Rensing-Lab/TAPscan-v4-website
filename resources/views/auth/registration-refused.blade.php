@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Registration Refused</div>

                <div class="card-body">
                  An admin user already exists, please <a href="/login">log in</a> with that account.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
