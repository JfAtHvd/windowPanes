<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()){
            $user = Auth::user();
            $timesStr = $user->fastest_times_json;
            $fastestTimes = explode(",", $timesStr);
            if($fastestTimes[0] != ""){
                for($i = 0; $i < sizeof($fastestTimes); $i++){
                    $t = $fastestTimes[$i];
                    $minutes = floor(((int)$t / 60));
					$seconds = (string)((int)$t % 60);
					if(strlen($seconds)  == 1){
						$seconds = "0".$seconds;
					}
					$fastestTimes[$i] = $minutes.":".$seconds;
                }
            }
            return view('home')->with([
                'user' => $user,
                'fastestTimes' => $fastestTimes
            ]);
        } else {
            return view('home');
        }
    }
}
