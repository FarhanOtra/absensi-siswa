<?php

namespace App\Providers;
use App\Models\User;
use App\Models\Leave;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Student_classroom;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('admin', function(User $user){
           return $user->role == 'admin'; 
        });

        Gate::define('teacher', function(User $user){
            return $user->role == 'teacher'; 
         });

        view()->composer('elements.sidebar', function($view)
        {
            if(Auth('sanctum')->user()->role == 'admin'){
                $view->with('unreadCount', Leave::where('status',1)->count());
            }

            if(Auth('sanctum')->user()->role == 'teacher'){
                $classroom = Classroom::where('teacher_id', Auth('sanctum')->user()->id)->first();
                if(isset($classroom)){
                    $view->with('unreadCount', Leave::join('student_classrooms','student_classrooms.id','leaves.student_classroom_id')->where('student_classrooms.classroom_id',$classroom->id)->where('leaves.status',1)->count());
                }
            }
        });
    }
}
