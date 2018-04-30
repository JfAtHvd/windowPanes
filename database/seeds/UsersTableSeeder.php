<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
	{

		$user = \App\User::firstOrCreate([
			'email' => 'jill@harvard.edu',
			'name' => 'Jill TestUser',
			'password' => \Hash::make('helloworld'),
			'highest_level' => 3,
			'fastest_times_json' => '{}'
		]);

		$user = \App\User::firstOrCreate([
			'email' => 'jamal@harvard.edu',
			'name' => 'Jamal TestUser',
			'password' => \Hash::make('helloworld'),
			'highest_level' => 3,
			'fastest_times_json' => '{}'			
		]);
	}
}
/*
'level' => 1,
			'solve_time' => 11,
			'total_solve_time' => 11,
			'pattern_json' => "{}",
			'level_json' => "{}",
			'user_id' => 1,
		]);

		Puzzle::insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'level' => 2,
			'solve_time' => 12,
			'total_solve_time' => 19,
			'pattern_json' => "{}",
			'level_json' => "{}",
			'user_id' => 1,
		]);

		Puzzle::insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'level' => 3,
			'solve_time' => 13,
			'total_solve_time' => 100,
			'pattern_json' => "{}",
			'level_json' => "{}",
			'user_id' => 1,
		]);

		Puzzle::insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'level' => 1,
			'solve_time' => 4,
			'total_solve_time' => 4,
			'pattern_json' => "{}",
			'level_json' => "{}",
			'user_id' => 2,
		]);

		Puzzle::insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'level' => 2,
			'solve_time' => 7,
			'total_solve_time' => 30,
			'pattern_json' => "{}",
			'level_json' => "{}",
			'user_id' => 2,
		]);

		Puzzle::insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'level' => 3,
			'solve_time' => 7,
			'total_solve_time' => 200,
			'pattern_json' => "{}",
			'level_json' => "{}",
			'user_id' => 2,
	
			
'highest_level' => 3,
'fastest_times_json' => "{
	'single' : {
		'1' : 11,
		'2' : 19,
		'3' : 100
	}',
	'total' : '{
		'1' : 11,
		'2' : 19,
		'3' : 100
	}'
}"

*/