<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abfrage extends Model
{
    use HasFactory;

    protected $table = 'abfragen';

    public function antworten()
    {
    	return $this->hasMany(AbfrageAntwort::class)->orderBy('titel');
    }

    public function jahrgang()
    {
        return $this->belongsTo(Jahrgang::class);   
    }

    public function child()
    {
        return $this->belongsTo(Abfrage::class, 'child_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Abfrage::class, 'parent_id', 'id');
    }
}
