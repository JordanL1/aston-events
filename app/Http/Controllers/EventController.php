<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Event;
use App\EventImage;
use Gate;
use Storage;

class EventController extends Controller
{
    public function createForm() {
      if (Gate::allows('create', Event::class)) {
        return view('/create');
      }
      else {
        return redirect('login');
      }
    }

    public function updateForm($id) {
      $event = Event::find($id);

      if (Gate::allows('update', $event)) {
        return view('/update', ['event' => $event, 'id' => $id]);
      }
      else {
        return redirect(route('showById', ['id' => $id]));
      }
    }

    public function createEvent(CreateEventRequest $request) {
      DB::transaction(function() use ($request) {
        $event = Event::create([
          'title' => $request->input('title'),
          'description' => $request->input('description'),
          'location' => $request->input('location'),
          'category' => $request->input('category'),
          'date_time' => $request->input('date_time'),
          'organiser_id' => auth()->user()->id
        ]);

        if(isset($request->photos)) {
          foreach($request->photos as $photo) {
            $filename = $photo->store('event_images');

            $eventImage = new EventImage;
              $eventImage->event_id = $event->id;
              $eventImage->filename = $filename;
              $eventImage->save();
          }
        }
      });

      # will not work as $event is local to transaction closure. how can i make this work?
      // if (isset($event->id)) {
      //   return redirect(route('showById', ['id' => $event->id]));
      // }
      // else {
        return redirect(route('all'));
      //}
    }

    public function updateEvent(UpdateEventRequest $request, $id) {
      DB::transaction(function() use ($request, $id) {
        $event = Event::find($id);

        $event->title = $request->input('title');
        $event->description = $request->input('description');
        $event->location = $request->input('location');
        $event->category = $request->input('category');
        $event->date_time = $request->input('date_time');

        $event->save();
      });
    }

    public function deleteEvent(Request $request) {
      $event = Event::find($request->input('event_id'));

      if (Gate::allows('delete', $event)) {
        DB::transaction(function() use ($event) {
          $images = EventImage::where('event_id', '=', $event->id)->get();

          foreach ($images as $image) {
            Storage::delete($image->filename);
            $image->delete();
          }
          $event->delete();
        });

        return redirect(route('all'));
      }
      else {
        return redirect(route('showById', ['id' => $event->id]));
      }
    }

}
