<?php

namespace App;



class GroupeStudent
{
    public  $name;
    public  $CC;
    public $CI;
    public $CF;

    function __construct( $name, $CI , $CC , $CF ) {
        $this->name = $name;
        $this->CC = $CC;
        $this->CF = $CF;
        $this->CI = $CI;
    }
}
