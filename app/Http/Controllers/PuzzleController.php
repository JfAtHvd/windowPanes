<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PuzzleController extends Controller
{

	/**
	* GET /singlegame
	*/
    public function play() {
        return view('play');
	}
}
