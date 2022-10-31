<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Jahrgang;
use App\Models\Schuljahr;
use App\Models\Abfrage;
use App\Models\BuchtitelSchuljahr;
use App\Models\Schueler;
use App\Models\Buchwahl;

class Anmeldung extends Component
{
    use WithFileUploads;

    // static props
    public $currentStep = 1;

    public $anrede   = '';
    public $nachname = '';
    public $vorname  = '';
    public $strasse  = '';
    public $ort      = '';
    public $zip      = '';
    public $email    = '';

    public $ermaessigung   = 0;
    public $bescheinigung1 = null;
    public $bescheinigung2 = null;

    public $summeKaufen = 0;
    public $summeLeihen = 0;
    public $summeLeihenReduziert = 0;

    public $zustimmung = '';

    // model binding props
    public Jahrgang $jahrgang;

    // dynamic props (Eloquent Collections)
    public $abfragen;
    public $buecherliste;
    public $leihliste;
    public $leihlisteEbooks;
    public $kaufliste;

    // dynamic props (Arrays)
    public $abfrageAntworten = [];
    public $wahlen = [];
    public $ebooks = [];
    
    public function mount()
    {
        $this->jahrgang     = Jahrgang::find(41);

        $this->abfragen        = collect();
        $this->buecherliste    = collect();
        $this->leihliste       = collect();
        $this->leihlisteEbooks = collect();
        $this->kaufliste       = collect();
    }
    
    public function getSchuljahrProperty()
    {
        return Schuljahr::where('aktiv', 1)->first();
    }

    protected $messages = [
        'anrede.required'     => 'Die Anrede muss angegeben werden.',
        'vorname.required'    => 'Der Vorname muss angegeben werden.',
        'nachname.required'   => 'Der Nachame muss angegeben werden.',
        'strasse.required'    => 'Die Straße muss angegeben werden.',
        'zip.required'        => 'Die PLZ muss angegeben werden.',
        'zip.size'            => 'Die PLZ muss 5-stellig sein.',
        'zip.numeric'         => 'Die PLZ darf nur aus Ziffern bestehen.',
        'ort.required'        => 'Der Ort muss angegeben werden.',
        'email.required'      => 'Die Email muss angegeben werden.',
        'email.email'         => 'Die Email muss eine gültige Email-Adresse sein.',
        'abfrageAntworten.*'  => 'Diese Abfrage muss beantwortet werden.',
        'zustimmung.required' => 'Die Zustimmung muss erteilt werden.',
    ];

    protected $rules = [
        'jahrgang.id' => 'required',
    ];

    public function render()
    {
        return view('livewire.anmeldung');
    }

    /**
     * Step 1
     */
    public function firstStepSubmit()
    {
        #################### Formular-Daten validieren #####################

        $validatedData = $this->validate([
            'anrede'   => 'required',
            'vorname'  => 'required',
            'nachname' => 'required',
            'strasse'  => 'required',
            'zip'      => 'required|numeric',
            'ort'      => 'required',
            'email'    => 'required|email',
        ]);

        #################### Datei-Uploads verarbeiten #####################

        if( isset($this->bescheinigung1) ) {
            $this->bescheinigung1->store('uploads');
        }

        if( isset($this->bescheinigung2) ) {
            $this->bescheinigung2->store('uploads');
        }

        #################### Abfragen vorbereiten #####################
        
        // (Ober-) Abfragen holen
        $this->abfragen = $this->jahrgang->abfragen->whereNull('parent_id');

        #################### Ergebnisarray für Step 2 initialisieren #####################

        if( empty($this->abfrageAntworten) ) {
            foreach($this->abfragen as $abfr) {
                $this->abfrageAntworten[$abfr->id] = NULL;
            }
        }

        $this->currentStep = 2;
    }

    /**
     * Step 2
     */
    public function secondStepSubmit()
    {
        $validatedData = $this->validate([
            'abfrageAntworten.*'  => 'required',
        ]);
        
        #################### Bücherliste generieren #####################
        
        // Bücherliste für den Jahrgang holen
        $this->buecherliste = $this->jahrgang->buchtitel;

        // Bücherliste nach Abfrage-Antworten filtern
        foreach($this->abfrageAntworten as $idAbfrage => $antwAbfrage) {
            $abfr = Abfrage::find($idAbfrage);
        
            foreach($abfr->antworten as $antw) {

                // Wenn die aktuelle Antwort NICHT der gegebenen Antwort entspricht,
                // müssen die mit dieser Antwort verknüpften Buchtitel herausgefiltert werden
                if ( $antw->id != $antwAbfrage ) {

                    // Ober-Abfrage: alle Buchtitel des verknüpften Faches herausfiltern
                    if( empty($abfr->parent_id) ) { 
                        $fach = $antw->fach_id;
                        $this->buecherliste = $this->buecherliste->filter(function ($btsj) use ($fach) {
                            return $btsj->buchtitel->fach_id != $fach;
                        });
                    } 
                    // Unter-Abfrage: alle mit dieser Unter-Abfrage verknüpfte Buchtitel herausfiltern
                    else { 
                        $this->buecherliste = $this->buecherliste->diff($antw->buchtitel);
                    }
                }

            }
        }

        #################### Ergebnisarray für Step 3 initialisieren #####################

        if( empty($this->wahlen) ) {
            foreach($this->buecherliste as $btsj) {
                if ( isset($btsj->leihpreis) ) {
                    $this->wahlen[$btsj->id] = '1';
                } else {
                    $this->wahlen[$btsj->id] = '3';
                }
            }
        }

        /*
        $schueler = $user->schuelerInSchuljahr($jahrgang->schuljahr->vorjahr->id)->first();
        if(!empty($schueler)) {
            $leihbuecher = $schueler->buecher->pluck('buchtitel_id');
        } else {
            $leihbuecher = [];
        }
        */

        $this->currentStep = 3;
    }

    // Unterabfrage anzeigen
    public function show($id) {
        $abfr = Abfrage::find($id);
        if( !$this->abfragen->contains($abfr) ) {
            $key = $this->abfragen->search(function($i) use ($abfr) {
                return $i->id == $abfr->parent_id;
            });
            $this->abfragen->splice($key+1, 0, [$abfr]);
        }
    }
    
    // Unterabfrage verstecken
    public function hide($id) {
        $abfr = Abfrage::find($id);
        if( $this->abfragen->contains($abfr) ) {
            $this->abfrageAntworten = array_diff($this->abfrageAntworten, $abfr->antworten->pluck('id')->toArray());
            $key = $this->abfragen->search(function($i) use ($id) {
                return $i->id == $id;
            });
            $this->abfragen->pull($key);
        }
    } 
    
    
    /**
     * Step 3
     */
    public function thirdStepSubmit()
    {
        $leihen = array_filter($this->wahlen, function ($val) { return $val <= 2; });
        $this->leihliste = BuchtitelSchuljahr::findMany(array_keys($leihen));

        $kaufen = array_filter($this->wahlen, function ($val) { return $val == 3; });
        $this->kaufliste = BuchtitelSchuljahr::findMany(array_keys($kaufen));

        $this->leihlisteEbooks = $this->leihliste->filter(function ($val) {
            return isset($val->ebook);
        }); 

        // Pflicht-Ebooks auswählen
        foreach($this->leihlisteEbooks as $btsj){
            if($btsj->ebook_pflicht>0) {
                $this->ebooks[$btsj->id] = 1;
            }
        }

        $this->currentStep = 4;
    }

    /**
     * Step 4
     */
    public function fourthStepSubmit()
    {
        $this->summeKaufen = $this->kaufliste->sum('kaufpreis');
        $this->summeLeihen = $this->leihliste->sum('leihpreis');

        if( !empty($this->ebooks) ) {
            $summeEbooks = BuchtitelSchuljahr::findMany(array_keys($this->ebooks))->sum('ebook');
            $this->summeLeihen += $summeEbooks;
        }
        
        $this->summeLeihenReduziert = $this->summeLeihen;
        switch($this->ermaessigung) {
            case 1 :  $this->summeLeihenReduziert = $this->summeLeihenReduziert * 0.8; break;
            case 2 :  $this->summeLeihenReduziert = 0; break;
        }

        $this->currentStep = 5;
    }

    public function submit()
    {
        $validatedData = $this->validate([
            'zustimmung'  => 'required',
        ]);

        #################### Neuen Schüler erstellen #####################

        $user = Auth::user();

        $schueler = new Schueler;
        $schueler->user_id        = $user->id;
        $schueler->vorname        = $user->vorname;
        $schueler->nachname       = $user->nachname;
        $schueler->betrag         = $this->summeLeihen;
        $schueler->jahrgang_id    = $this->jahrgang->id;
        $schueler->ermaessigung   = $this->ermaessigung;

        if( !empty( $this->bescheinigung1 ) ) {
            $schueler->bescheinigung1 = $this->bescheinigung1;
        }

        if( !empty( $this->bescheinigung2 ) ) {
            $schueler->bescheinigung2 = $this->bescheinigung2;
        }

        // Klasse zuweisen
        /*
        $klassen = $jahrgang->klassen;

        // Jahrgänge 5-11: Klasse des Schülers zuweisen
        if($klassen->count() > 1) {
            $kuerzel = substr($user->klasse, 2, 2); // aktuelles Klassenkürzel (A-F) ermitteln
            if($kuerzel!=null) { // wenn nicht Jg. 05
                $klassen = $klassen->filter(function($value, $key) use ($kuerzel) {
                    if(strpos($value->bezeichnung, $kuerzel)) {
                        return $value;
                    }
                }); // richtige Klasse unter den Klassen im Jahrgang ermitteln
            }
        }

        if($klassen->count() > 0) {
            $klasse = $klassen->first();
            $schueler->klasse_id = $klasse->id;
        } 
        else {
            $klasse = $jahrgang->klassen->first();
            $schueler->klasse_id = $klasse->id; 
        }
        */

        $schueler->save();


        #################### Familie aktualisieren oder neu erstellen #####################

        /*
        if(empty($user->familie_id)) {
            $familie = Familie::where('name', '=', $user->nachname)
                ->where('strasse', 'like', '%'.substr($user->strasse,0,5).'%')
                ->first();

            if(empty($familie)) {
                $familie = new Familie;
            }
        } 
        else {  
            $familie = $user->familie;
        }

        $familie->name          = $user->nachname;
        $familie->strasse       = $this->strasse;
        $familie->re_anrede     = $this->anrede;
        $familie->re_nachname   = $this->nachname;
        $familie->re_vorname    = $this->vorname;
        $familie->re_strasse_nr = $this->strasse;
        $familie->re_ort        = $this->ort;
        $familie->re_plz        = $this->zip;
        $familie->email         = $this->email;

        if( $this->ermaessigung == 1 ) { $familie->erm     = 1; }
        if( $this->ermaessigung == 2 ) { $familie->befreit = 1; }

        $familie->save();

        if( empty($user->familie_id) ) {
            $user->familie_id = $familie->id;
            //$familie->users()->save($user);
            $user->save();
        }
        */


        #################### Bücherwahlen speichern #####################

        /*
        // Vorjahres-Schüler holen
        $schuelerVorjahr = $user->schuelerInSchuljahr($jahrgang->schuljahr->vorjahr->id)->first();
        if(!empty($schuelerVorjahr)) {
            $leihbuecher = $schuelerVorjahr->buecher; // Leihbücher des Vorjahres holen
        }
        */
 
        //Buchwahl::where('schueler_id', $schueler->id)->delete(); // überflüssig?! vorhandene Wahl löschen...
          
        // alle Wahlentscheidungen durchgehen
        foreach($this->wahlen as $btsj_id => $wahl)
        {
            // neue Wahl erzeugen
            $buchwahl = new Buchwahl;
            $buchwahl->schueler_id  = $schueler->id;
            $buchwahl->buchtitel_id = $btsj_id;
            $buchwahl->wahl         = $wahl;
 
            if(!empty($this->ebooks)) {
                if(in_array($btsj_id, $this->ebooks)) {
                    $buchwahl->ebook = 1;
                }
            }
 
            $buchwahl->save();
 
            /*
            // bei Verlängerung das bereits ausgeliehene Buch ins neue Schuljahr übertragen
            if($wahl == 2) 
            {
                // ausgeliehendes Buch des aktuellen Buchtitel ermitteln
                $btsj  = BuchtitelSchuljahr::find($btsj_id);
                $bt_id = $btsj->buchtitel_id;
                $buch  = $leihbuecher->filter(function($value, $key) use ($bt_id) {
                    if( $value->buchtitel_id == $bt_id ) {
                        return $value;
                    }
                })->first();
 
                // BuchHistorien-Eintrag machen (Buch zurückgeben)
                $eintrag = new BuchHistorie;
                $eintrag->buch_id   = $buch->id;
                $eintrag->titel     = $buch->buchtitel->titel;
                $eintrag->nachname  = $schuelerVorjahr->nachname;
                $eintrag->vorname   = $schuelerVorjahr->vorname;
                $eintrag->email     = $schuelerVorjahr->user->email;
                $eintrag->klasse    = $schuelerVorjahr->klasse->bezeichnung;
                $eintrag->schuljahr = $schuelerVorjahr->klasse->jahrgang->schuljahr->schuljahr;
                $eintrag->ausgabe   = $buch->ausleiher_ausgabe;
                $eintrag->rueckgabe = Carbon::now();
                $eintrag->save();
 
                // Buch neu ausleihen
                $schueler->buecher()->save($buch);  // Bucn wird dabei beim Vorjahres-Schüler gelöscht
                $buch->ausleiher_ausgabe = Carbon::now();
                $buch->save();
            }
            */
        }
 
        /*
        $mail = new OrderConfirm($schueler);
        Mail::to($familie->email)->send($mail);
        */

        $this->currentStep = 6;
    }

     /**
     * Allgemeine Funktionen
     */

    public function resetForm() {
        $this->resetExcept('jahrgang', 'abfragen', 'buecherliste', 'kaufliste', 'leihliste', 'leihlisteEbooks');
        $this->mount();
    }

    public function step($step)
    {
        if($step < $this->currentStep) {
            $this->currentStep = $step;    
        }
    }

    public function updatedJahrgang() {
        $this->reset('abfrageAntworten', 'wahlen', 'ebooks');
    }

    public function updatedAbfrageAntworten() {
        $this->reset('wahlen', 'ebooks');
    }

    public function updatedWahlen() {
        $this->reset('ebooks');
    }

    public function updatedErmaessigung() {
        $this->reset('bescheinigung1', 'bescheinigung2');
    }
}