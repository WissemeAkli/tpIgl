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
            $groupeStudent = Student ::where("id",$user->idCompte)->first()->groupeId;

            // on récupère la liste des modules :
            $studentmodules = Module ::where("groupe_id",$groupeStudent)->get();
            $notes=[];
            foreach($studentmodules as $module)
            {
             /// pour chaque module on va récupérer les 3 notes :
                $CI = 0.0;
                $CF = 0.0;
                $CC = 0.0;
                $inter = Note ::where("module_id",$module->id)
                ->where("type","CC")
                ->where("etudiant_id",$user->idCompte)->get();
                if(sizeof($inter)>0){
                    $CC = $inter[0]->valeur;
                }


                $inter = Note ::where("module_id",$module->id)
                ->where("type","CI")
                ->where("etudiant_id",$user->idCompte)->get();
                if(sizeof($inter)>0){
                    $CI = $inter[0]->valeur;
                }

                $inter = Note ::where("module_id",$module->id)
                ->where("type","CF")
                ->where("etudiant_id",$user->idCompte)->get();
                if(sizeof($inter)>0){
                    $CF= $inter[0]->valeur;
                }
                $studentModule=[];
                $studentModule["CI"] = $CI;
                $studentModule['CF']= $CF;
                $studentModule['CC'] = $CC;
                $studentModule['nom'] = $module->name;

                array_push($notes , $studentModule);
            }
            return response()->json(['notes'=>$notes]);


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


}
