<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
      'title', 'description', 'location', 'category', 'date_time', 'organiser_id'
    ];
}
