<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function details(){
        $user = Auth::user();
        if($user->typeCompte !="T"){
            return response()->json(['error'=>"You are A student you can't access teacher space"], 401);
        }
        $teacherModules = Module::where("teacher_id" , $user->idCompte)->get();
        print_r($teacherModules)



    }
}
