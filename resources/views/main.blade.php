@extends('layouts.app')

@section('content')
<div class="container">
  @foreach ($events as $event)
    <div class="card">
      <h5 class="card-title">{{ $event->title }}</h5>
      <h6 class="card-subtitle">{{ $event->{ 'date-time' } }}</h6>
      <p class="card-text">{{ $event->description }}</p>
      <a href="{{ route('showById', [$event->id]) }}" class="btn">Details</a>
    </div>
  @endforeach
</div>
@endsection
