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

class StudentController extends Controller
{
    public function notes()
    {
        $user = Auth::user();
        if($user->typeCompte !="S"){
            return response()->json(['error'=>"Student access only"], 401);
        }
        else
        {
            // on récupère le groupe
            $groupeStudent = Student ::where("id",$user->idCompte)->first();
            
            // on récupère la liste des modules :
            $studentmodules = Module ::where("groupe_id",$groupeStudent);
            $notes=[];
            foreach($studentmodules as $module)
            {
             /// pour chaque module on va récupérer les 3 notes :
                $inter = Note ::where("module_id",$module)
                ->where("type","CC")
                ->where("etudiant_id",$user->idCompte)->get();
                $notes[$module]['CC']=$inter;

                $inter = Note ::where("module_id",$module)
                ->where("type","CI")
                ->where("etudiant_id",$user->idCompte)->get();
                $notes[$module]['CI']=$inter;

                $inter = Note ::where("module_id",$module)
                ->where("type","CF")
                ->where("etudiant_id",$user->idCompte)->get();
                $notes[$module]['CF']=$inter;

            }



        }
        



    }
    public function details(){
        $user = Auth::user();
        if($user->typeCompte !="S"){
            return response()->json(['error'=>"Student access only"], 401);
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
            $studentGroupe =new GroupeStudent($user->name , 0.0 , 0.0 , 0.0);
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

            $students[$student->id] =$studentGroupe ;
        }
        return response()->json(["student"=>$students]);
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
