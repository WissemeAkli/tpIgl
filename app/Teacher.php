<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post', 'profession'
    ];
    /**
         * The table associated with the model.
         *
         * @var string
         */
        protected $table = 'teacher';
}
