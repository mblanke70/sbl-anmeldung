<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buchtitel extends Model
{
    use HasFactory;

    protected $table = 'buchtitel';

	/**
     * Liefert die Bücher zu diesem Buchtitel.
     */
    public function buecher()
    {
    	return $this->hasMany(Buch::class);
    }

    /**
     * Liefert die Ebooks zu diesem Buchtitel.
     */
    /*
    public function ebooks()
    {
        return $this->hasMany(Ebook::class);
    }
    */

    /**
     * Liefert das Fach zu diesem Buchtitel.
     */
    public function fach()
    {
        return $this->belongsTo(Fach::class);
    }  

    /**
     * Liefert die Bestellungen zu diesem Buchtitel.
     */
    /*
     public function bestellungen()
    {
        return $this->hasMany(Buchwahl::class)->where('wahl', 1);
    }
    */

    public function buchtitelSchuljahr()
    {
        return $this->hasMany(BuchtitelSchuljahr::class)->orderBy('schuljahr_id', 'DESC');
    }

    public function buchtitelSchuljahr2($schuljahr_id)
    {
        return $this->hasMany(BuchtitelSchuljahr::class)->where('schuljahr_id', $schuljahr_id)->get();
    }    

    public function schuljahre()
    {
         return $this->belongsToMany(Schuljahr::class)
            ->withPivot('leihpreis');
    }
}
