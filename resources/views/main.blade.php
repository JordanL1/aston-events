
@extends('layouts.app')

@section('content')
<div class="container">
  <br>
  <div class="form-row">
  <br>
    <form method="get" action="{{ url()->full() }}" >
      <label for="sort-by">Sort by </label>
      <select name="order" id="sort-by">
        <option value="likes">popular</option>
        <option value="date_time">date</option>
        <option value="user">organiser</option>
      </select>
      <label for="in-order">in </label>
      <select name="by" id="in-order">
        <option value="DESC">descending</option>
        <option value="ASC">ascending</option>
      </select>
      <button type="submit" class="btn btn-link" onclick="">go</button>
    </form>
  </div>

  @foreach ($events as $event)
    <div class="card m-4">

      <div class="card-header">
        <div class="row">
        <div class="col-sm-8">
          <h5 class="card-title">{{ $event->title }}</h5>
          <h6 class="card-subtitle">{{ $event->location }}</h6>
        </div>

        <div class="col-sm-1 text-md-right">
          <span class="badge badge-success">{{ $event->category }}</span>
        </div>

        @if (!empty (Auth::user()) && Auth::user()->id == $event->organiser_id)
        <div class="col-sm-1 text-md-right">
          <a href="/update/event/{{ $event->id }}"><button type="button" class="btn btn-info">Update</button></a>
        </div>

        <div class="col-sm-1">
        <form method="post" action="{{ route('deleteEvent', $event->id) }}" class="text-md-right">
            @csrf
            <input type="hidden" name="page" value="event" />
            <input type="hidden" name="_method" value="delete" />
            <input type="hidden" name="event_id" value="{{ $event->id }}" />
            <button type="submit" class="btn btn-danger">Delete</button>
          </form>
        </div>
        @else
        <a class="nav-link" href="{{ route('show', ['user' => $event->organiser_id ]) }}"><i class="fa fa-user-circle"></i> {{ $users[$event->id]->name }}  </a></li>
        @endif
      </div>
    </div>

      @if (!empty($images[$event->id]) && count($images[$event->id]) > 0)
      <div id="carousel-{{ $event->id }}" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="d-block w-100" src="{{ asset('storage/' . $images[$event->id][0]->filename) }}" alt="{{ $event->title }}" />
          </div>
        @if (count($images[$event->id]) > 1)
          @for ($i = 1; $i < count($images[$event->id]); $i++)
          <div class="carousel-item">
            <img class="d-block w-100" src="{{ asset('storage/' . $images[$event->id][$i]->filename) }}" alt="{{ $event->title }}" />
          </div>
          @endfor
        @endif
          </div>
      </div>
      @endif

      <div class="card-body">
        <div class="card-text">
          <p><strong>{{ $event->date_time }}</strong><p>
          <p class="card-text">{{ $event->description }}</p>
        </div>
      </div>

      <div class="card-footer">
        <div class="row">
          <div class="col-md-1">
            <button type="button" id="like-btn-{{ $event->id }}" class="btn btn-primary" onclick="likeEvent({{ $event->id }})">
              <i class="fa fa-thumbs-o-up"></i>
              <span id="like-text-{{ $event->id }}">{{ $event->likes }}</span>
            </button>
          </div>

          <div class="col-md-2">
            <a href="{{ $users[$event->id]->email }}"><button type="button" class="btn btn-link text-md-left">
              Contact the organiser
            </button></a>
          </div>
        </div>
      </div>
    </div>
  @endforeach
  </div>
</div>

@endsection
