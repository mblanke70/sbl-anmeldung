<!-- STEP 5 -->
<div class="row {{ $currentStep != 5 ? 'd-none' : '' }}" id="step-5">

    <h5>Bestellbestätigung</h5>

    <p>Die Summe der 

    @switch($ermaessigung)
        @case(1) <span style="color: red">um 20% ermäßigten</span> @break
        @case(2) <span style="color: red">um 100% ermäßigten</span> @break
    @endswitch

    Leihgebühren beträgt:
    </p>
        
    <h4 style="text-align: center;">{{ number_format($summeLeihenReduziert, 2, ',', '') }} &euro;</h4>

    <p>Dieser Betrag wird zu Beginn des nächsten Schuljahres per Bankeinzug von dem Konto eingezogen, von dem auch vierteljährlich das Schulgeld für Ihr Kind eingezogen wird. Dafür benötigen wir Ihre Einverständniserklärung. Diese gilt nur einmalig und muss in jedem Jahr erneuert werden.</p>

    <p>Nach Abschluss des Leihverfahrens bleiben die Listen der gewählten Leih- und Kaufbücher weiterhin hier einsehbar.</p>

    <div class="alert alert-primary my-4 text-center" role="alert">
        <div class="form-check">
            <input type="checkbox" wire:model="zustimmung" class="form-check-input @error('zustimmung') is-invalid @enderror" id="zustimmung" value="1" />
            <label class="form-check-label" for="zustimmung">
                Ich bin damit einverstanden, dass die Leihgebühr für das Schuljahr 2022/23 von dem Konto eingezogen wird, von dem auch das Schulgeld für mein Kind eingezogen wird.
            </label>
        </div>
        @error('zustimmung') 
            <div class="invalid-feedback d-block">{{ $message }} </div> 
        @enderror
    </div>

    <div class="text-end">
        <button wire:click="step(4)" class="btn btn-danger" type="button">Zurück</button>
        <button wire:click="submit" class="btn btn-primary" type="button">Abschicken</button>
    </div>

    @include('livewire.uebersicht')

</div>