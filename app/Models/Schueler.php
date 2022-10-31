<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Schueler extends Model
{
    use HasFactory;

    protected $table = 'schueler';

    public function buecher()
    {
        return $this->morphMany(Buch::class, 'ausleiher')->with('buchtitel');
    }

    /**
     * Liefert die Ebooks dieses Schülers.
     */
    /*
    public function ebooks()
    {
        return $this->hasMany(Ebook::class);
    }
    */

    /**
     * Liefert die Bücherwahlen des Schülers.
     */   
    /*
    public function buecherwahlen()
    {
        return $this->hasMany(Buchwahl::class)->with('buchtitel')->orderBy('wahl');
    }
    */

    public function buchwahlen()
    {
        return $this->hasMany(Buchwahl::class);
    }

    /**
     * Liefert die Liste der der Bücher, die der Schüler ausleiht.
     */
    public function leihliste()
    {
        return $this->hasMany(Buchwahl::class)->whereIn('wahl', array(1, 2));
    }

    /**
     * Liefert die Liste der der Bücher, die der Schüler kauft.
     */
    public function kaufliste()
    {
        return $this->hasMany(Buchwahl::class)->where('wahl', 3);
    }

	/**
     * Liefert die Klasse des Schülers.
     */
    public function klasse()
    {
    	 return $this->belongsTo(Klasse::class);
    }

    /**
     * Liefert den Jahrgang des Schülers.
     */
    public function jahrgang()
    {
         return $this->belongsTo(Jahrgang::class);
    }

    /**
     * Liefert den mit dem Schüler verknüpften User.
     */
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
    
    /*
    public function familie()
    {
        return $this->belongsTo('App\Familie');
    }
    */

    /*
    public function buecherliste()
    {
        // Hole alle Buchtitel, die auf der Bücherliste des Jahrgangs des Schülers stehen       
        $buchtitel = $this->klasse->jahrgang->buchtitel->sortBy('buchtitel.fach.code');
        
        // Hole alle Bücher, die der Schüler derzeit ausgeliehen hat
        $buecher   = $this->buecher;
        
        // Hole alle Buchbestellungen, die der Schüler abgegeben hat
        $wahlen    = $this->buecherwahlen->keyBy('buchtitel_id');

        // Durchlaufe die Bücherliste und ergänze zu jedem Buchtitel
        //   - die zugehörige Bestellung
        //   - den aktuellen Leihstatus

        $buchtitel = $buchtitel->map(
            function ($item, $key) use ($wahlen, $buecher) {
                $bw = $wahlen->get($item->id);
                if($bw==null) {
                    $item['wahl'] = 4;
                } else {
                    $item['wahl']    = $bw->wahl;
                    $item['wahl_id'] = $bw->id;
                }

                $item['ausgeliehen'] = $buecher->contains('buchtitel_id', $item->buchtitel->id) ? 1 : 0;

                return $item;
            }
        );

        return $buchtitel->sortBy('wahl');
    }
    */
    
    /*
    public function buecherliste2()
    {
        $jg = $this->jahrgang_id;
        $s  = $this->id;
        
        $buecherliste = DB::table('buchtitel_schuljahr')
        ->join('buchtitel_schuljahr_jahrgang', function ($join) use ($jg) {
            $join->on('buchtitel_schuljahr.id', '=', 'buchtitel_schuljahr_jahrgang.buchtitel_schuljahr_id')
                 ->where('buchtitel_schuljahr_jahrgang.jahrgang_id', '=', $jg);
        })
        ->join('buchtitel', 'buchtitel.id', '=', 'buchtitel_schuljahr.buchtitel_id')
        ->leftJoin('buchwahlen', function ($join) use ($s) {
            $join->on('buchtitel_schuljahr.id', '=', 'buchwahlen.buchtitel_id')
                ->where('buchwahlen.schueler_id', '=', $s);
        })
        ->leftJoin('buecher', function($join) use ($s) {
            $join->on('buchtitel.id', '=', 'buecher.buchtitel_id')
                ->where('ausleiher_id', '=', $s);
        })
        ->get();

        return $buecherliste;
    }
    */

    /**
     * Liefert den alphabetisch nächsten Ausleiher aus der gleichen Klasse
     */
    /*
    public function next()
    {
        return $this->klasse->schueler()
            ->where('nachname', '>=', $this->nachname)
            ->where(function ($query) {
                $query->where  ('nachname', '>', $this->nachname)    
                      ->orWhere('vorname' , '>', $this->vorname);    
            })
            ->orderBy('nachname', 'asc')
            ->orderBy('vorname' , 'asc')
            ->select('schueler.id')
            ->first();
    }
    */

    /**
     * Liefert den alphabetisch vorherigen Ausleiher aus der gleichen Klasse
     */
    /*
    public function prev()
    {
        return $this->klasse->schueler()
            ->where('nachname', '<=', $this->nachname)
            ->where(function ($query) {
                $query->where  ('nachname', '<', $this->nachname)    
                      ->orWhere('vorname' , '<', $this->vorname);    
            })
            ->orderBy('nachname', 'desc')   // funktioniert nicht ???
            ->orderBy('vorname' , 'desc')
            ->select('schueler.id', 'schueler.nachname', 'schueler.vorname')
            ->first();
    } 
    */   
}
