<!-- add 'Edit' or similar shown if organiser viewing? -->
@extends('layouts.app')

@section('content')
<div class="container">
  <div class="card">
    <h5 class="card-title">{{ $event->title }}</h5>
    <h6 class="card-subtitle">{{ $event->date_time }}</h6>
    <p class="card-text">{{ $event->description }}</p>
    <a href="events/{{ $event->id }}" class="btn">Details</a>
  </div>
</div>
@endsection
