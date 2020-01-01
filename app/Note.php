<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'etudiant_id', 'module_id' , 'type', 'valeur'
    ];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'note';
}
