<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BuchtitelSchuljahr extends Pivot
{
    use HasFactory;

    protected $table = 'buchtitel_schuljahr';

    public $incrementing = true;

    /*
    public function buecherlisten()
    {
        return $this->belongsToMany(
        	'App\Buecherliste' ,
        	'buchtitel_schuljahr_buecherliste', 
        	'buchtitel_schuljahr_id', 
        	'buecherliste_id');
    }
    */

    public function jahrgaenge()
    {
        return $this->belongsToMany(
            Jahrgang::class ,
            'buchtitel_schuljahr_jahrgang', 
            'buchtitel_schuljahr_id', 
            'jahrgang_id');
    }

	public function buchtitel()
    {
        return $this->belongsTo(Buchtitel::class)->with('fach');
    }

    public function schuljahr()
    {
    	return $this->belongsTo(Schuljahr::class);
    }

    /*
     * n:m-Beziehung BuchtitelSchuljahr-AbfrageAntwort
     */
    public function antworten()
    {
        return $this->belongsToMany(
            AbfrageAntwort::class, 
            'abfrage_antwort_buchtitel_schuljahr', 
            'buchtitel_schuljahr_id', 
            'abfrage_antwort_id'
        );
    }

    /*
    public function buchwahlen()
    {
        return $this->hasMany(
            'App\Buchwahl', 
            'buchtitel_id'
        );   
    } 
    */      
}
