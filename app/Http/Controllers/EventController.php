<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateEventRequest;
use App\Event;
use App\EventImage;
use Gate;
use Storage;

class EventController extends Controller
{
    public function showForm() {
      if (Gate::allows('create', Event::class)) {
        return view('/create');
      }
      else {
        return redirect('login');
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
