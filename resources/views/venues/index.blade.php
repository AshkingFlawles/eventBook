@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Venues</h1>
    <div class="row">
        <div class="col-md-12">
            <ul class="list-group">
                @foreach ($venues as $venue)
                    <li class="list-group-item">{{ $venue->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection