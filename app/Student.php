<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'annee', 'groupeid'
    ];
    /**
         * The table associated with the model.
         *
         * @var string
         */
        protected $table = 'student';
}
