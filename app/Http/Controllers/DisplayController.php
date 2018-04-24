<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;

class DisplayController extends Controller
{
    public function showAll() {
      $events = Event::all();

      return view('/main', array('events' => $events));
    }

    public function showById($id) {
      $event = Event::find($id);

      # add condition to check whether event found, return different view if not
      return view ('/event', array('event' => $event));
    }

    public function showByType($type) {
      $events = Event::find($type);

      return view ('/main', array('events' => $events));
    }
}
