@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <div class="row">
        <div class="col-md-4">
            <h2>Venues</h2>
            <ul class="list-group">
                @foreach ($venues as $venue)
                    <li class="list-group-item">{{ $venue->name }}</li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-4">
            <h2>Events</h2>
            <ul class="list-group">
                @foreach ($events as $event)
                    <li class="list-group-item">{{ $event->title }}</li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-4">
            <h2>Bookings</h2>
            <ul class="list-group">
                @foreach ($bookings as $booking)
                    <li class="list-group-item">Event: {{ $booking->event}} | Tickets: {{ $booking->num_tickets }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
