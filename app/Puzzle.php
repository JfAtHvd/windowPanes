<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Puzzle extends Model
{
    public function user() {
		# Puzzle belongs to User
		# Define an inverse one-to-many relationship.
		return $this->belongsTo('App\User');
	}
}
