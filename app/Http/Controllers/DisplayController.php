<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\EventImage;
use App\User;

class DisplayController extends Controller
{
    public function showAll() {
      $events = Event::all();

      return view('/main', array('events' => $events));
    }

    /**
      * Display selected events in the main view.
      *
      *  - Filter events by event column parameters (e.g. category)
      *  - Sort events by order parameters
      *  - If no filter applied, show all
      *  - If no order params, sort by likes in descending order
      *
      *  @param Request $request GET request containing optional query params
      *  @return mixed main view with requested events
     */
    public function show(Request $request) {
      $params = array();
      $users = array();
      $images = array();

      if (!empty($request->query('user'))) {
        $params['organiser_id'] = $request->query('user');
      }

      if (!empty($request->query('category'))) {
        $params['category'] = $request->query('category');
      }

      if (!empty($request->query('event'))) {
        $params['id'] = $request->query('event');
      }

      if (!empty($request->query('order'))) {
        $order['order'] = $request->query('order');

        if (!empty($request->query('by'))) {
          $order['by'] = $request->query('by');
        }
        else {
          $order['by'] = 'DESC';
        }
      }

      if (!isset($order)) {
        if (!isset($params)) {
          $events = Event::orderBy('likes', 'DESC')->get();
        }
        else {
          $events = Event::where($params)->orderBy('likes', 'DESC')->get();
        }
      }
      else {
        if (!isset($params)) {
          $events = Event::orderBy($order['order'], $order['by'])->get();
        }
        else {
          $events = Event::where($params)->orderBy($order['order'], $order['by'])->get();
        }
      }

      foreach ($events as $event) {
        $images[$event->id] = EventImage::where('event_id', '=', $event->id)->get();
        $users[$event->id] = User::find($event->organiser_id);
      }


      return view('/main', ['events' => $events, 'users' => $users, 'images' => $images]);
    }
}
