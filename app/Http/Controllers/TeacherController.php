<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Teacher;
use App\Groupe;
use Log ;
use App\Module;

class TeacherController extends Controller
{
    public function details(){
        $user = Auth::user();
        if($user->typeCompte !="T"){
            return response()->json(['error'=>"You are A student you can't access teacher space"], 401);
        }
        $teacherModules = Module::where("teacher_id" , $user->idCompte)->get();
        $modules= [];
        foreach($teacherModules as $module){
            $groupe_id = $module->groupe_id;
            $groupeName = Groupe::where("id", $groupe_id)->first()->name;
            $moduleName = $module->name;
            if(array_key_exists( $moduleName, $modules)){
                $modules[$moduleName][$groupe_id]= $groupeName;
            }else{
                $modules[$moduleName] = [$groupe_id => $groupeName];
            }
        }
        return response()->json(["succes"=>$modules, "user"=>$user]);
    }
}
