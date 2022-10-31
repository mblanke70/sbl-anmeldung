<!-- STEP 2 -->
<div class="row {{ $currentStep != 2 ? 'd-none' : '' }}" id="step-2">

    @foreach ($this->abfragen as $abfr)
    
    <fieldset class="form-group mb-2">
    
        <div class="row">
            <legend class="col-form-label col-sm-4">
                <strong>@if($abfr->parent_id) --> @endif {{ $abfr->titel }}</strong>
            </legend>
            <div class="col-sm-8">
                
                @foreach ($abfr->antworten as $antw)   
                <div class="form-check form-check-inline">
                    @if ($abfr->child_id)
                        <!-- Abfrage mit Unterabfrage -->
                        <input wire:model.defer="abfrageAntworten.{{$abfr->id}}" name="abfrageAntworten.{{$abfr->id}}" class="form-check-input @error('abfrageAntworten.'.$abfr->id) is-invalid @enderror" type="radio" value="{{ $antw->id }}" id="antw-{{ $antw->id }}" 
                            wire:click="@if ($antw->fach_id) show('{{ $abfr->child_id }}') @else hide('{{ $abfr->child_id }}') @endif" />
                    @else
                        <!-- Abfrage ohne Unterabfrage -->
                        <input wire:model.defer="abfrageAntworten.{{$abfr->id}}" name="abfrageAntworten.{{$abfr->id}}" class="form-check-input @error('abfrageAntworten.'.$abfr->id) is-invalid @enderror" type="radio" value="{{ $antw->id }}" id="antw-{{ $antw->id }}" />
                    @endif
                    <label class="form-check-label" for="antw-{{ $antw->id }}">{{ $antw->titel }}</label>
                </div>
                @endforeach

            @error('abfrageAntworten.'.$abfr->id) 
                <div class="invalid-feedback d-block">{{ $message }} </div> 
            @enderror
            
            </div>
        </div>
    
    </fieldset>        
    
    @endforeach

    <div class="text-end">
        <button wire:click="step(1)" class="btn btn-danger" type="button">Zurück</button>
        <button wire:click="secondStepSubmit"class="btn btn-primary" type="button">Weiter</button>
    </div>

</div>