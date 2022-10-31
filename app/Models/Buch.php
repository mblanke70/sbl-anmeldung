<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buch extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Die Tabelle, die mit diesem Model verknüpft ist.
     *
     * @var string
     */
    protected $table = 'buecher';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'ausleiher_ausgabe', 'aufnahme', 'inventur'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

	/**
     * Liefert den Buchtitel des Buches.
     */
    public function buchtitel()
    {
    	return $this->belongsTo('App\Buchtitel');
    }

    /*
     * Liefert den Ausleiher des Buches, einen Schüler oder Lehrer (falls vorhanden).
     */
    /*
    public function ausleiher()
    {
        return $this->morphTo();
    } 
    */   

    /*
     * Liefert alle Einträge aus der Buchhistorie
     */
    /*
    public function historie()
    {
        return $this->hasMany('App\BuchHistorie');
    }
    */
}
