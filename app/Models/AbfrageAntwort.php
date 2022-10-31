<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbfrageAntwort extends Model
{
    use HasFactory;

     /**
     * Die Tabelle, die mit diesem Model verknüpft ist.
     *
     * @var string
     */
    protected $table = 'abfragen_antworten';

    /**
     * Liefert die Abfrage zu dieser Antwort.
     */
    public function abfrage()
    {
    	return $this->belongsTo(Abfrage::class);
    }

    /**
     * Liefert das Fach, auf das sich diese Antwort bezieht.
     */
    public function fach()
    {
        return $this->belongsTo(Fach::class);
    }

    /**
     * n:m-Beziehung: BuchtitelSchuljahr <-> AbfrageAntwort
     *
     * Liefert die Buchtitel, die zu dieser Antwort gehören (auf der Bücherliste bleiben müssen).
     * Die Buchtitel, die zu der Antwort-Alternative gehören, werden gestrichen.
     */
    public function buchtitel()
    {
        return $this->belongsToMany(
            BuchtitelSchuljahr::class, 
            'abfrage_antwort_buchtitel_schuljahr', 
            'abfrage_antwort_id', 
            'buchtitel_schuljahr_id'
        );
    }
}