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
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role');
            $table->string('image')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('school_years', function (Blueprint $table) {
            $table->id();
            $table->integer('year_start');
            $table->integer('year_end');
            $table->timestamps();
        });

        Schema::create('periods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_year_id');
            $table->string('semester');
            $table->integer('active');
            $table->timestamps();

            $table->foreign('school_year_id')->references('id')->on('school_years')->onDelete('cascade');
        });

        Schema::create('holiday_groups', function (Blueprint $table) {
            $table->id();      
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('holidays', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('holiday_group_id');
            $table->unsignedBigInteger('school_year_id');  
            $table->date('date');
            $table->timestamps();

            $table->foreign('holiday_group_id')->references('id')->on('holiday_groups')->onDelete('cascade');
            $table->foreign('school_year_id')->references('id')->on('school_years')->onDelete('cascade');
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
            $table->string('grade');
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->unsignedBigInteger('school_year_id');
            $table->timestamps();
            
            $table->foreign('teacher_id')->references('user_id')->on('teachers')->onDelete('set null');
            $table->foreign('school_year_id')->references('id')->on('school_years')->onDelete('cascade');
        });
        
        Schema::create('students', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->string('nis')->unique();
            $table->string('name');
            $table->string('gender');
            $table->string('parent_number')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('student_classrooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('classroom_id');
            $table->timestamps();
            
            $table->foreign('student_id')->references('user_id')->on('students')->onDelete('cascade');
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('cascade');
        });

        Schema::create('attendances', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('period_id');            
            $table->date('date')->unique();
            $table->time('time');
            $table->time('time_limit');
            $table->timestamps();

            $table->foreign('period_id')->references('id')->on('periods')->onDelete('cascade');
        });

        Schema::create('student_attendances', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('attendance_id');
            $table->unsignedBigInteger('student_classroom_id');
            $table->time('time_in')->nullable();
            $table->integer('status');
            $table->unsignedBigInteger('modified_by');
            $table->string('note')->nullable();
            $table->timestamps();

            $table->foreign('attendance_id')->references('id')->on('attendances')->onDelete('cascade');
            $table->foreign('student_classroom_id')->references('id')->on('student_classrooms')->onDelete('cascade');
            $table->foreign('modified_by')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('leaves', function (Blueprint $table) {
            $table->id();         
            $table->unsignedBigInteger('student_classroom_id');         
            $table->date('date_start'); 
            $table->date('date_end'); 
            $table->integer('type');
            $table->string('title');
            $table->string('desc');
            $table->string('attachment');
            $table->integer('status');
            $table->timestamps();

            $table->foreign('student_classroom_id')->references('id')->on('student_classrooms')->onDelete('cascade');
        });

        Schema::create('leave_attendances', function (Blueprint $table) {
            $table->unsignedBigInteger('leave_id');
            $table->unsignedBigInteger('attendance_id');
            $table->timestamps();

            $table->primary(['attendance_id', 'leave_id']);

            $table->foreign('attendance_id')->references('id')->on('attendances')->onDelete('cascade');
            $table->foreign('leave_id')->references('id')->on('leaves')->onDelete('cascade');
        });

        
        DB::table('users')->insert(array('email'=>'admin@gmail.com', 'password'=>Hash::make('12345678'), 'role'=> 'admin', 'image'=>null));
        DB::table('teachers')->insert(array('user_id'=>'1', 'nip'=>'123456789', 'name'=> 'Admin'));
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
