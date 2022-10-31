<!-- STEP 4 -->
<div class="row {{ $currentStep != 4 ? 'd-none' : '' }}" id="step-4">
        
    <table class="table table-striped">

        <thead>
            <tr>
                <th>Ebook</th>
                <th>Preis</th>
                <th>Titel</th> 
                <th>Fach</th>
                <th>ISBN</th>
                <th>Verlag</th>
            </tr>
        </thead>
        
        <tbody>
            @foreach ($this->leihlisteEbooks as $bt)
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            
                            @if( $this->jahrgang->jahrgangsstufe>=7 && $this->jahrgang->jahrgangsstufe<=11 && $bt->ebook_pflicht>0)
                                <input type="checkbox" wire:model="ebooks.{{ $bt->id }}" name="ebooks.{{ $bt->id }}" class="custom-control-input" id="ebook-{{ $bt->id }}" value="1" disabled="disabled">
                            @else
                                <input type="checkbox" wire:model="ebooks.{{ $bt->id }}" name="ebooks.{{ $bt->id }}" class="custom-control-input" id="ebook-{{ $bt->id }}" value="1">
                            @endif
                            
                            <label class="custom-control-label" for="ebook-{{ $bt->id }}"></label>
                        </div>
                    </td>
                    <td>{{ $bt->ebook }} &euro;</td>
                    <td>{{ $bt->buchtitel->titel }}</td>
                    <td>{{ $bt->buchtitel->fach->code }}</td>
                    <td>{{ $bt->buchtitel->isbn }}</td>
                    <td>{{ $bt->buchtitel->verlag }}</td>
                </tr>
            @endforeach

        </tbody>

    </table> 

    <div class="text-end">
        <button wire:click="step(3)" class="btn btn-danger" type="button">Zurück</button>
        <button wire:click="fourthStepSubmit"class="btn btn-primary" type="button">Weiter</button>
    </div>

</div>