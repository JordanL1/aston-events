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

    public function show(Request $request) {

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

      // if (!isset($params)) {
      //   $events = Event::all();
      // }
      // else {
      //   $events = Event::where($params);
      // }

      if (!isset($order)) {
        //$events = $events->get();

        if (!isset($params)) {
          $events = Event::all();
        }
        else {
          $events = Event::where($params)->get();
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

      return view('/main', array('events' => $events));
    }
}
