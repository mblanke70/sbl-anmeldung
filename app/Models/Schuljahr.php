<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schuljahr extends Model
{
    use HasFactory;

    protected $table = 'schuljahre';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'von', 'bis'
    ];

    public function istAktiv()
    {
        return $this->aktiv == 1;
    }

    public function vorjahr()
    {
        return $this->hasOne(Schuljahr::class, 'id', 'prev');
    }

    public function jahrgaenge()
    {
        return $this->hasMany(Jahrgang::class); 
    }

    /*
    public function klassen()
    {
        return $this->hasManyThrough('App\Klasse', 'App\Jahrgang'); 
    }    

    public function buchtitel()
    {
        return $this->belongsToMany('App\Buchtitel')
            ->using('App\BuchtitelSchuljahr')
            ->withPivot('leihpreis');
    }
    */
}