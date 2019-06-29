<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zonas extends Model {
    protected $table = 'zonas';
    protected $primaryKey = 'idZona';
    public $timestamps = true;
    protected $fillable = [
        'nombre',
        'estado'
    ];

    protected $guarded = [];

}
