@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Event</div>
                @if (count($errors) > 0)
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                @endif


                <div class="card-body">
                    <form method="POST" action="{{ route('createEvent') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">Event Title:</label>

                            <div class="col-md-6">
                                <input id="title" type="text" name="title" required autofocus />
                            </div>
                        </div>

                        <div class="form-group row">
                          <label for="description" class="col-md-4 col-form-label text-md-right">Description:</label>
                          <div class="col-md-6">
                            <input id="description" type="textbox" name="description" />
                          </div>
                        </div>

                        <div class="form-group row">
                          <label for="location" class="col-md-4 col-form-label text-md-right">Location:</label>
                          <div class="col-md-6">
                            <input id="location" type="text" name="location" />
                          </div>
                        </div>

                        <div class="form-group row">
                          <label for="category" class="col-md-4 col-form-label text-md-right">Category:</label>
                          <div class="col-md-6">
                            <select id="category" name="category" required>
                              <option value="sport">Sport</option>
                              <option value="culture">Culture</option>
                              <option value="other">Other</option>
                            </select>
                          </div>
                        </div>

                        <div class="form-group row">
                          <label for="date_time" class="col-md-4 col-form-label text-md-right">Date and Time:</label>
                          <div class="col-md-6">
                            <input id="date_time" type="datetime-local" name="date_time" required />
                          </div>
                        </div>

                        <div class="form-group row">
                          <label for="photos" class="col-md-4 col-form-label text-md-right">Photos (can attach more than one):</label>
                          <div class="col-md-6">
                            <input id="photos" type="file" name="photos[]" multiple />
                          </div>
                        </div>

                        <div class="form-group row">

                          <div class="col-md-6">
                            <button type="reset" class="btn btn-primary">Reset</button>
                          </div>

                          <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Create</button>
                          </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
