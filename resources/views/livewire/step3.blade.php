<!-- STEP 3 -->
<div class="row {{ $currentStep != 3 ? 'd-none' : '' }}" id="step-3">

    <table id="buchtitel" class="table table-striped">
        <thead>
            <tr>
                <th>Titel</th> 
                <th>Fach</th>
                <th>ISBN</th>
                <th>Verlag</th>
                <th>Preis</th>
                <th>Leihgebühr</th>
                <th>Leihen</th>
                <th>Kaufen</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($buecherliste as $bt)
                
                <tr>
                    <td scope="row">{{ $bt->buchtitel->titel }}</td>
                    <td>{{ $bt->buchtitel->fach->code }}</td>
                    <td>{{ $bt->buchtitel->isbn }}</td>
                    <td>{{ $bt->buchtitel->verlag }}</td>
                    <td class="text-right">
                        @isset($bt->kaufpreis)
                            {{ number_format($bt->kaufpreis, 2, ',', '') }} €
                        @endisset
                    </td>
                    <td class="text-right">
                        @isset($bt->leihpreis)
                            {{ number_format($bt->leihpreis, 2, ',', '') }} €
                        @endisset
                    </td>
                    <td class="text-center">
                        @isset( $bt->leihpreis )
                            <div class="custom-control custom-radio">
                                <input wire:model.defer="wahlen.{{ $bt->id }}" name="wahlen.{{ $bt->id }}" type="radio" id="leihen-{{ $bt->id }}" class="custom-control-input" value="1" />
                                <label class="custom-control-label" for="leihen-{{ $bt->id }}"></label>
                            </div>
                        @endisset
                    </td>
                    <td class="text-center">
                        @isset( $bt->kaufpreis )
                            <div class="custom-control custom-radio">
                                <input wire:model.defer="wahlen.{{ $bt->id }}" name="wahlen.{{ $bt->id }}" type="radio" id="kaufen-{{ $bt->id }}" class="custom-control-input" value="3" />
                                <label class="custom-control-label" for="kaufen-{{ $bt->id }}"></label>
                            </div>
                        @endisset
                    </td>
        
                </tr>

            @endforeach

        </tbody>

    </table>  

    <div class="text-end">
        <button wire:click="step(2)" class="btn btn-danger" type="button">Zurück</button>
        <button wire:click="thirdStepSubmit"class="btn btn-primary" type="button">Weiter</button>
    </div>

</div>