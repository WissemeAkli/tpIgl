<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Teacher;
use App\Note;
use App\GroupeStudent;
use App\Groupe;
use App\Student;
use App\User;
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
            $group["id"]= $groupe_id;
            $group["nom"]= Groupe::where("id", $groupe_id)->first()->name;
            $group["moduleId"] = $module->id;
            $moduleName = $module->name;
            $index = $this->containsModule($module->name , $modules);
            if($index >=0){
                array_push($modules[$index]['groupes'] , $group);
            }else{
                $teacherModule["nom"]= $moduleName ;
                $moduleGroups = [];
                array_push($moduleGroups , $group);
                $teacherModule["groupes"]=$moduleGroups;
                array_push($modules , $teacherModule);
            }
        }
        return response()->json(["modules"=>$modules, "user"=>$user]);
    }


    public function containsModule($moduleName , $modules){
        for ($i = 0; $i < count($modules); $i++) {
            if($modules[$i]['nom'] == $moduleName){
                return $i;
            }
        }
        return -1;
    }

    public function groupe(Request $request){
        $user = Auth::user();
        if($user->typeCompte !="T"){
             return response()->json(['error'=>"You are A student you can't access teacher space"], 401);
        }
        $moduleId = $request->module;
        $groupeId = $request->groupe;
        $studentsInGroup = Student::where('groupeId', $groupeId)->get();
        $students = [];
        foreach($studentsInGroup as $student){
            $user = User::where('idCompte' , $student->id)->where('typeCompte' , 'S')->first();
            $notes = Note::where('module_id', $moduleId)->where('etudiant_id' , $student->id)->get();
            $studentGroupe =new GroupeStudent($student->id , $user->name , 0.0 , 0.0 , 0.0);
            if(sizeof($notes)!=0) {
                $CI = 0.0 ;
                $CF = 0.0 ;
                $CC = 0.0 ;
                foreach($notes as $note){
                    if($note->type =='CC'){
                        $CC = $note->valeur ;
                    }else if($note->type=='CF'){
                        $CF = $note->valeur;
                    }else{
                        $CI = $note->valeur;
                    }
                }
                $studentGroupe->CI = $CI;
                $studentGroupe->CC = $CC;
                $studentGroupe->CF = $CF;
            }

            array_push($students , $studentGroupe);
        }
        return response()->json(["liste_etud"=>$students , "success"=>200]);
    }

    public function addNote(Request $request){
        $user = Auth::user();
        if($user->typeCompte !="T"){
            return response()->json(['error'=>"You are A student you can't access teacher space"], 401);
        }
        $moduleId = $request->module;
        $studentId = $request->student;
        $type = $request->type ;
        $value = $request->value;
        $notes  = Note::where('module_id', $moduleId)->where('etudiant_id' , $studentId)->where('type' , $type)->get();
        if(sizeof($notes)==0){
            Note::create(['etudiant_id'=> $studentId
                , 'module_id'=> $moduleId , 'type'=> $type, 'valeur'=>$value]);
            return response()->json(["success"=>200 ]);
        }else{
            Note::where('module_id', $moduleId)->where('etudiant_id' , $studentId)->where('type' , $type)->update(["valeur"=>$value]);
            return response()->json(["success"=>200 ]);
        }

    }

}
