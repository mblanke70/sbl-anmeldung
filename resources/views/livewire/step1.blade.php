 <!-- STEP 1 -->
<div class="row {{ $currentStep != 1 ? 'd-none' : '' }}" id="step-1">

    <div class="col-md-6 p-3">
        <h4 class="mb-3">Rechnungsanschrift</h4>

        <fieldset class="form-group mb-2">
            <div class="row">
                <legend class="col-form-label col-sm-2 pt-0">Anrede</legend>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <input wire:model="anrede" class="form-check-input  @error('anrede') is-invalid @enderror" type="radio" value="m" id="m">
                        <label class="form-check-label" for="m">Herr</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input wire:model="anrede" class="form-check-input @error('anrede') is-invalid @enderror" type="radio" value="w" id="frau">
                        <label class="form-check-label" for="frau">Frau</label>
                    </div>
                    @error('anrede') <div class="invalid-feedback d-block">{{ $message }} </div> @enderror
                </div>
            </div>
        </fieldset>
        <div class="form-group row mb-2">
            <label for="vorname" class="col-sm-2 col-form-label">Vorname</label>
            <div class="col-sm-10">
                <input class="form-control @error('vorname') is-invalid @enderror" wire:model="vorname" type="text">
                @error('vorname')  <div class="invalid-feedback">{{ $message }} </div> @enderror
            </div>
        </div>
        <div class="form-group row mb-2">
            <label for="nachname" class="col-sm-2 col-form-label">Nachname</label>
            <div class="col-sm-10">
                <input class="form-control @error('nachname') is-invalid @endif" wire:model="nachname" type="text">
                @error('nachname') <div class="invalid-feedback">{{ $message }} </div> @enderror
            </div>
            
        </div>
        <div class="form-group row mb-2">
            <label for="strasse" class="col-sm-2 col-form-label">Straße</label>
            <div class="col-sm-10">
                <input class="form-control @error('strasse') is-invalid @endif" wire:model="strasse" type="text">
                @error('strasse') <div class="invalid-feedback">{{ $message }} </div> @enderror
            </div>
        </div>
        <div class="form-group row mb-2">
            <label for="plz" class="col-sm-2 col-form-label">PLZ</label>
            <div class="col-sm-10">
                <input class="form-control @error('zip') is-invalid @endif" wire:model="zip" type="text">
                @error('zip') <div class="invalid-feedback">{{ $message }} </div> @enderror
            </div>
        </div>
        <div class="form-group row mb-2">
            <label for="ort" class="col-sm-2 col-form-label">Ort</label>
            <div class="col-sm-10">
                <input class="form-control @error('ort') is-invalid @endif" wire:model="ort" type="text">
                @error('ort') <div class="invalid-feedback">{{ $message }} </div> @enderror
            </div>
        </div>
        <div class="form-group row mb-2">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input class="form-control @error('email') is-invalid @endif" wire:model="email" type="text">
                @error('email') <div class="invalid-feedback">{{ $message }} </div> @enderror
            </div>
        </div>
    </div>

    <div class="col-md-6 p-3">
        
        <h4>Jahrgang im Schuljahr 2022/23</h4>

        <p>Geben Sie an, in welchem Jahrgang sich ihr Kind im nächsten Schuljahr befindet.</p>

        <div class="form-group row mb-4">
            <label class="col-md-2 col-form-label" for="jahrgang">Jahrgang</label>
            <div class="col-sm-10">
                <select wire:model="jahrgang.id" class="form-select px-2" id="jahrgang">
                    @foreach($this->schuljahr->jahrgaenge as $jg)
                    <option value="{{ $jg->id }}">{{ $jg->jahrgangsstufe}} ({{ $this->schuljahr->schuljahr }})</option>	
                    @endforeach
                </select>
            </div>
        </div>

        <hr/>

        <h4>Ermäßigung auf den Leihpreis</h4>

        <p>
            Familien mit drei oder mehr schulpflichtigen Kindern erhalten für jedes Kind 20% Ermässigung 
            auf das Entgelt für die Ausleihe. Der Nachweis über jedes schulpflichtige Geschwisterkind, das 
            nicht an der Ursulaschule ist, erfolgt durch Hochladen einer Schulbescheinigung oder Abgabe im Sekretariat. Für Familien, die
            vom Schulgeld befreit sind, ist die Ausleihe kostenlos.
        </p>

        <div class="form-group row mb-3">
            <label class="col-md-2 col-form-label" for="ermaessigung">Ermäßigung</label>
            <div class="col-md-10">
                <select wire:model="ermaessigung" class="form-select px-2" id="ermaessigung">
                    <option value="0">keine Ermäßigung</option>
                    <option value="1">20% Ermäßigung</option>
                    <option value="2">Befreiung</option>
                </select>
            </div>
        </div>

        @if($this->ermaessigung == 1)
        <div id="file-upload" class="my-3">
            <div class="form-group mb-3">
                <label for="bescheinigung1" class="form-label">Schulbescheinigung für 1. "externes" Geschwisterkind</label>
                <input class="form-control" type="file" wire:model="bescheinigung1" id="bescheinigung1" accept="image/*">
            </div>
            <div class="form-group mb-3">
                <label for="bescheinigung2" class="form-label">Schulbescheinigung für 2. "externes" Geschwisterkind</label>
                <input class="form-control" type="file" wire:model="bescheinigung2" id="bescheinigung2" accept="image/*">
            </div>
        </div>
        @endif

    </div>

    <div class="text-end">
        <button class="btn btn-primary" wire:click="firstStepSubmit" type="button">Weiter</button>
    </div>

</div>