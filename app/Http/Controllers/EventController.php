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
  /**
    * Check authorisation and get form to create event
    *
    *  @return mixed create event view if successful, redirect to login if auth fails
   */
    public function createForm() {
      if (Gate::allows('create', Event::class)) {
        return view('/create');
      }
      else {
        return redirect('login');
      }
    }

    /**
      * Check authorisation and get form to update event
      *
      *  @param int $id event id to update
      *  @return mixed update event view if successful, redirect to event if auth fails
     */
    public function updateForm($id) {
      $event = Event::find($id);

      if (Gate::allows('update', $event)) {
        return view('/update', ['event' => $event, 'id' => $id]);
      }
      else {
        return redirect(route('show', ['event' => $id]));
      }
    }

    /**
      * Add event to DB. Authorisation and validation are done by request.
      * DB changes rolled back in event of failure.
      *
      *  @param CreateEventRequest $request request containing valid array of input data necessary to create event
      *  @return mixed redirect to show all events
     */
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
        return redirect(route('show'));
      //}
    }

    /**
      * Update event in DB. Authorisation and validation done by request.
      * DB changes rolled back in event of failure.
      *
      * @todo update image functionality
      *
      *  @param UpdateEventRequest $request request containing valid array of input data necessary to create event
      *  @param int $id event id to update
      *  @return mixed redirect to show updated event
     */
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

      return redirect(route('show', ['event' => $id]));
    }

    /**
      * Check authorisation and delete event from DB, and corresponding images from DB and storage.
      * DB changes rolled back in event of failure.
      *
      *  @param Request $request request delete request
      *  @return mixed redirect to show all events, or current event in case of failure
     */
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

        return redirect(route('show'));
      }
      else {
        return redirect(route('show', ['event' => $event->id]));
      }
    }

    /**
      * Increment likes value of given event and return response
      *
      *  @param Event $event event to increment
      *  @return json status: 200, data: new likes value
     */
    public function likeEvent(Event $event) {
      $event->likes = $event->likes + 1;
      $event->save();

      return response()->json($event->likes, 200);
    }

}
