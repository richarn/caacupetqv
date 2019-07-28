<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model {
    protected $table = 'roles';
    protected $primaryKey = 'idRole';
    public $timestamps = true;
    protected $fillable = [
    	'nombre', 'flag', 'estado'
    ];

    protected $guarded = [];
}
