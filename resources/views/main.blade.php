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
      <button id="like-btn-{{ $event->id }}" class="btn" onclick="likeEvent({{ $event->id }})">
        <i class="fa fa-thumbs-o-up"></i>
        <span id="like-text-{{ $event->id }}">{{ $event->likes }}</span>
      </button>
    </div>
  @endforeach
</div>
@endsection
