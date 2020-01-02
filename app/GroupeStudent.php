<?php

namespace App;



class GroupeStudent
{
    public  $nom;
    public $id;
    public  $CC;
    public $CI;
    public $CF;

    function __construct($id ,  $nom, $CI , $CC , $CF ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->CC = $CC;
        $this->CF = $CF;
        $this->CI = $CI;
    }
}
