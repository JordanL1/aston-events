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
      $event = Event::findOrFail($id);

      # add condition to check whether event found, return different view if not
      return view ('/event', array('event' => $event));
    }

    public function showByCategory(Request $request) {
      $category = $request->query('category');
      $events = Event::where('category', '=', $category)->get();

      return view('/main', array('events' => $events));
    }

    public function filter(Request $request) {

      if (!empty($request->query('user'))) {
        $params['organiser_id'] = $request->query('user');
      }

      if (!empty($request->query('category'))) {
        $params['category'] = $request->query('category');
      }

      if (!empty($request->query('event'))) {
        $params['id'] = $request->query('event');
      }

      $events = Event::where($params)->get();

      return view('/main', array('events' => $events));
    }
}
