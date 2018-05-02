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
        
        $thisLevel = $request->level;
        $totalSolveTime = $request->total_solve_time;
        
        $puzzle->level = $thisLevel;
        $puzzle->solve_time = $request->solve_time;
        $puzzle->total_solve_time = $totalSolveTime;
        $puzzle->pattern_json = $request->pattern_json;
        $puzzle->level_json = $request->level_json;
        $puzzle->puzzle_resets = $request->puzzle_resets;
        $puzzle->number_flips = $request->number_flips;
        $puzzle->total_number_flips = $request->total_number_flips;
        
        $puzzle->user_id = $user->id;
        
        $puzzle->save();
        
        $highestLevel = $user->highest_level;
        if(!$highestLevel || $thisLevel > $highestLevel){
            $user->highest_level = $thisLevel;
        }
        
        $timeStr = $user->fastest_times_json;
        $fastestTimes = explode(",", $user->fastest_times_json);
        if(!array_key_exists(($thisLevel - 1), $fastestTimes)  ||
                $fastestTimes[$thisLevel - 1] == ""  || 
                $totalSolveTime < $fastestTimes[$thisLevel - 1]){
            $fastestTimes[$thisLevel - 1] = $totalSolveTime;
            $timeStr = $fastestTimes[0];
            for($i = 1; $i < sizeof($fastestTimes); $i++){
                $timeStr = $timeStr.",".$fastestTimes[$i];
            }
            $user->fastest_times_json = $timeStr;
        }
        
        $user->save();
        
        return redirect('/play');
	}
}
