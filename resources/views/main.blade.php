@extends('layouts.app')

@section('content')
<div class="container">
  @foreach ($events as $event)
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">{{ $event->title }}</h5>
        <h6 class="card-subtitle">{{ $event->location }}</h6>
      </div>
      <div class="card-body">
        <div class="card-text">
          <p class="card-text">{{ $event->description }}</p>
        </div>
        <a href="{{ route('showById', [$event->id]) }}" class="btn">Details</a>
      </div>
    </div>
  @endforeach
</div>
@endsection
