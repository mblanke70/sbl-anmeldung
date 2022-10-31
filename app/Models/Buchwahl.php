<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buchwahl extends Model
{
    use HasFactory;

    protected $table = 'buchwahlen';

    public function buchtitel()
    {
    	return $this->belongsTo(BuchtitelSchuljahr::class, 'buchtitel_id');
    }

	public function schueler()
    {
    	return $this->belongsTo(Schueler::class);
    }   
}
