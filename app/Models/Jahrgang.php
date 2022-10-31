<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jahrgang extends Model
{
    use HasFactory;

    protected $table = 'jahrgaenge';

    /**
     * Liefert die Klassen des Jahrgangs.
     */
    /*
     public function klassen()
    {
    	return $this->hasMany(Klasse::class);
    }
    */

    /*
     * Liefert das Schuljahr, dem dieser Jahrgang zugeordnet ist.
     */
    public function schuljahr()
    {
        return $this->belongsTo(Schuljahr::class);
    }

    /*
     * Liefert alle Ausleiher des Jahrgangs.
     */
    /*
    public function schueler()
    {
        return $this->hasManyThrough(Schueler::class, Klasse::class);   
    }
    */

    /**
     * Liefert die Abfragen, die zu diesem Jahrgang gehört.
     */
    public function abfragen()
    {
        return $this->hasMany(Abfrage::class);   
    }

    /**
     * Liefert die Bücherliste, die zu diesem Jahrgang gehört.
     */
    public function buchtitel()
    {
        return $this->belongsToMany(
            BuchtitelSchuljahr::class,
            'buchtitel_schuljahr_jahrgang', 
            'jahrgang_id', 
            'buchtitel_schuljahr_id'
        )->withPivot(
            'ebook_pflicht'
        )->with([
            'buchtitel' => function ($q) {
              $q->orderBy('titel', 'asc');
            }, 
            'buchtitel.fach' => function ($q) {
              $q->orderBy('code', 'asc');
            }
        ]);
    }
    
}
