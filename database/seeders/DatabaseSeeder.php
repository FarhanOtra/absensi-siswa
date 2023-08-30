<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Classroom;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Student_attendance;
use App\Models\Student_classroom;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        $school_year = DB::table('school_years')->insert([
            'year_start' => '2022',
            'year_end' => '2023'
        ]);

        $period = DB::table('periods')->insert([
            'school_year_id' => $school_year,
            'semester' => 'Ganjil',
            'active' => 1,
        ]);

        for($i = 1; $i <= 15; $i++){
            $user = DB::table('users')->insertGetId([
              'email' => $faker->unique()->email,
              'password' => Hash::make('12345678'),
              'role' => 'teacher',
            ]);
            DB::table('teachers')->insert([
                'user_id' => $user,
                'name' => $faker->name,
                'nip' => $faker->unique()->numberBetween(1000000000, 9999999999 ),
            ]); 
        }

        $teachers = Teacher::all()->pluck('user_id')->toArray();

        for($i = 1; $i <= 3; $i++){
            DB::table('classrooms')->insert([
              'school_year_id' => 1,
              'grade' => $faker->randomElement(['X', 'XI', 'XII']),
              'name' => $faker->unique()->numerify('Musik ##'),
              'teacher_id' => $faker->unique()->randomElement($teachers),
          ]);
        }

        for($i = 1; $i <= 45; $i++){
            $user = DB::table('users')->insertGetId([
              'email' => $faker->unique()->email,
              'password' => Hash::make('12345678'),
              'role' => 'student',
            ]);
            DB::table('students')->insert([
                'user_id' => $user,
                'name' => $faker->name,
                'nis' => $faker->unique()->numberBetween(100000, 999999 ),
                'gender' => $faker->randomElement(['P', 'L']),
                'parent_number' => $faker->phonenumber,
            ]); 
        }

        
        $students = Student::all();
        $classrooms = Classroom::all()->pluck('id')->toArray();
        foreach($students as $student){
            $student_classroom = DB::table('student_classrooms')->insert([
                'student_id' => $student->user_id,
                'classroom_id' => $faker->randomElement($classrooms),
            ]);
        }

        for($i = 0; $i <= 30; $i++){
            $now = Carbon::now();
            $date = $now->subDays($i)->format("Y-m-d");
            $month = Carbon::parse($date)->translatedFormat('m');

            $check = Carbon::parse($date);
            if(!$check->isWeekend()){
                $attendance = DB::table('attendances')->insertGetId([
                    'date' => $date,
                    'time' => '07:30:00',
                    'time_limit' => '08:30:00',
                    'period_id' => 1,
                  ]);
      
                  $student_classrooms = Student_classroom::all();
      
                  foreach($student_classrooms as $student_classroom){
                      DB::table('student_attendances')->insert([
                          'attendance_id' => $attendance,
                          'student_classroom_id' => $student_classroom->id,
                          'time_in' => '07:15',
                          'status' => $faker->randomElement([1, 2, 3, 4, 5]),
                          'status' => $faker->randomElement([1, 2, 3, 4, 5]),
                          'modified_by' => $student_classroom->student->user_id,
                      ]); 
                  };
            }  
        }
    }
}
