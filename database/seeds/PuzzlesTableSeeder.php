<?php

use Illuminate\Database\Seeder;

use App\Puzzle;

class PuzzlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Puzzle::insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'level' => 1,
			'solve_time' => 11,
			'total_solve_time' => 11,
			'puzzle_resets' => 0,
			'number_flips' => 1,
			'total_number_flips' => 1,
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
			'puzzle_resets' => 0,
			'number_flips' => 2,
			'total_number_flips' => 2,
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
			'puzzle_resets' => 0,
			'number_flips' => 3,
			'total_number_flips' => 3,
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
			'puzzle_resets' => 0,
			'number_flips' => 1,
			'total_number_flips' => 1,
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
			'puzzle_resets' => 0,
			'number_flips' => 2,
			'total_number_flips' => 2,
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
			'puzzle_resets' => 0,
			'number_flips' => 3,
			'total_number_flips' => 3,
			'pattern_json' => "{}",
			'level_json' => "{}",
			'user_id' => 2,
		]);
    }
}
