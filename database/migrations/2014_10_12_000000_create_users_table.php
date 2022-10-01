<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role');
            $table->string('image')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('periods', function (Blueprint $table) {
            $table->id();
            $table->string('years');
            $table->string('semester');
            $table->timestamps();
        });
        
        Schema::create('teachers', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->string('nip')->unique();
            $table->string('name');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->timestamps();
            
            $table->foreign('teacher_id')->references('user_id')->on('teachers')->onDelete('set null');
        });
        
        Schema::create('students', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('classroom_id')->nullable();
            $table->string('nis')->unique();
            $table->string('name');
            $table->string('gender');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('set null');
        });

        Schema::create('attendances', function (Blueprint $table) {
            $table->id();            
            $table->date('date');
            $table->string('month');
            $table->time('time');
            $table->integer('status');
            $table->unsignedBigInteger('period_id');
            $table->timestamps();

            $table->foreign('period_id')->references('id')->on('periods')->onDelete('cascade');
        });

        Schema::create('student_attendances', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('attendance_id');
            $table->unsignedBigInteger('student_id');
            $table->time('time_in')->nullable();
            $table->integer('status');
            $table->timestamps();

            $table->foreign('attendance_id')->references('id')->on('attendances')->onDelete('cascade');
            $table->foreign('student_id')->references('user_id')->on('students')->onDelete('cascade');
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('attendance_id');
            $table->integer('type');
            $table->string('desc');
            $table->string('attachment');
            $table->integer('status');
            $table->timestamps();

            $table->foreign('attendance_id')->references('id')->on('attendances')->onDelete('cascade');
            $table->foreign('student_id')->references('user_id')->on('students')->onDelete('cascade');
        });

        // Schema::create('permissions', function (Blueprint $table) {
        //     $table->id();            
        //     $table->unsignedBigInteger('student_id');
        //     $table->integer('type');
        //     $table->date('date');
        //     $table->string('description')->nullable();
        //     $table->string('attachment')->nullable();
        //     $table->integer('status');
        //     $table->timestamps();

        //     $table->foreign('student_id')->references('user_id')->on('students')->onDelete('cascade');
        // });
        
        DB::table('users')->insert(array('username'=>'admin','email'=>'admin@gmail.com', 'password'=>Hash::make('12345678'), 'role'=> 'admin', 'image'=>null));
        // DB::table('users')->insert(array('username'=>'guru1','email'=>'guru1@gmail.com', 'password'=>Hash::make('12345678'), 'role'=> 'teacher', 'image'=>null));
        // DB::table('users')->insert(array('username'=>'siswa1','email'=>'siswa1@gmail.com', 'password'=>Hash::make('12345678'), 'role'=> 'student', 'image'=>null));
        // DB::table('teachers')->insert(array('user_id'=>'2','nip'=> '12345678', 'name'=>'Bapak Rivaldo'));
        // DB::table('classrooms')->insert(array('name'=>'X MUSIK 1','teacher_id'=> '2'));
        // DB::table('students')->insert(array('user_id'=>'3','classroom_id'=> '1', 'nis'=>'12345678', 'name'=>'siswa1', 'gender'=>'P'));
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('teachers');
    }
}
