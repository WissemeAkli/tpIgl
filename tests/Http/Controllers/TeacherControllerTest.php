<?php

namespace Tests\Unit;

use App\Http\Controllers\TeacherController;

class TeacherControllerTest extends \PHPUnit_Framework_TestCase
{

    public function testGroupe()
    {
        $teacherModules = [
            [
                "id"=>1,
                "name"=>"IGL",
                "groupe_id"=>1
            ],
            [
                "id"=>2,
                "name"=>"IGL",
                "groupe_id"=>2
            ],
            [
                "id"=>2,
                "name"=>"IGL",
                "groupe_id"=>3
            ],
            [
                "id"=>3,
                "name"=>"RO",
                "groupe_id"=>1
            ]

        ];
        $groups = [
            [
                "id"=>1
                , "name"=>"1cs Gr1"
            ],
            [
                "id"=>2
                , "name"=>"1cs Gr2"
            ],
            [
                "id"=>3
                , "name"=>"1cs Gr3"
            ]
        ];
        $modules= [];
        foreach($teacherModules as $module){
            $groupe_id = $module->groupe_id;
            $group["id"]= $groupe_id;
            $group["nom"]= $this->getGroupeName($groupe_id, $groups);
            $moduleName = $module->name;
            $index = $this->containsModule($module->name , $modules);
            if($index >=0){
                array_push($modules[$index]['groupes'] , $group);
            }else{
                $teacherModule["nom"]= $moduleName ;
                $teacherModule["id"] = $module->id;
                $moduleGroups = [];
                array_push($moduleGroups , $group);
                $teacherModule["groupes"]=$moduleGroups;
                array_push($modules , $teacherModule);
            }
        }
        assertCount(2 , $modules);
        assertCount(3, $modules[0]->groupes);
    }
    private function getGroupeName($groupe_id , $groups){
        foreach ($groups as $group){
            if($group->id==$groupe_id){
                return $group->name;
            }
        }
        return "Gr";
    }

}
