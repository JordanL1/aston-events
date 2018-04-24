
@extends('layouts.app')

@section('content')
<div class="container">
  <div class="card">
    <div class="card-header">
      <h5 class="card-title">{{ $event->title }}</h5>
      <h6 class="card-subtitle">{{ $event->location }}</h6>
    </div>
    <div class="card-body">
      <div class="card-text">
        <p class="card-text">{{ $event->description }}</p>
      </div>

      <form method="post" action="{{ route('deleteEvent', $event->id) }}" class="text-md-right">
        @csrf
        <input type="hidden" name="page" value="event" />
        <input type="hidden" name="_method" value="delete" />
        <input type="hidden" name="event_id" value="{{ $event->id }}" />
        <button type="submit" class="btn">Delete</button>
      </form>
    </div>
  </div>
</div>
@endsection
