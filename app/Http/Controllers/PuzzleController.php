<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Puzzle;

class PuzzleController extends Controller
{

	/**
	* GET /play/new
	*/
    public function playNew() {
        return view('play')->with('new', true);
	}
	
	/**
	* GET /play
	*/
    public function play() {
        return view('play')->with('new', false);
	}
	
	/**
	* POST /save
	*/
    public function savePuzzleData(Request $request) {
        
        $user = Auth::user();
        $puzzle = new Puzzle();
        
        $puzzle->level = $request->level;
        $puzzle->solve_time = $request->solve_time;
        $puzzle->total_solve_time = $request->total_solve_time;
        $puzzle->pattern_json = $request->pattern_json;
        $puzzle->level_json = $request->level_json;
        
        $puzzle->user_id = $user->id;
        
        $puzzle->save();
        
        return redirect('/play');
	}
}

