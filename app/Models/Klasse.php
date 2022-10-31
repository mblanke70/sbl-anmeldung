<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klasse extends Model
{
    use HasFactory;
    
    protected $table = 'klassen';

    public function jahrgang()
    {
    	return $this->belongsTo(Jahrgang::class);
    }

    public function schuljahr()
    {
        return $this->jahrgang()->schuljahr();
    }

    public function schueler()
    {
        // mit QueryBuilder wegen der Sortierung nach Vor- und Nachnamen (in users)
        /*
        return DB::table('schueler')
            ->where('klasse_id', '=', $this->id)
            ->join('users', 'schueler.user_id', '=', 'users.id')
            ->join('klassen', 'schueler.klasse_id', '=', 'klassen.id')
            ->orderBy('nachname', 'asc')
            ->orderBy('vorname', 'asc')
            ->select('schueler.id as ausleiher_id', 'schueler.*', 'users.*', 'klassen.*');
        */
        return $this->hasMany(Schueler::class)
            ->orderBy('nachname', 'asc')
            ->orderBy('vorname',  'asc');
    }
}
