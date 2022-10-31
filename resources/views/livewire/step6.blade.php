    <!-- STEP 6 -->
<div class="row {{ $currentStep != 6 ? 'd-none' : '' }}" id="step-6">
    
    <h5>Ihre Bestellung ist aufgenommen worden.</h5>

    <p>Eine Bestellbestätigung ist per Email an die Adresse</p>
    <h5>{{ $email }}</h5>
    <p>versendet worden.</p>

    <p>Wenn Sie jetzt ein weiteres Kind anmelden möchten, müssen Sie sich erst einmal ausloggen.</p>

    <!--
    <div>
        <button wire:click="resetForm" class="btn btn-primary" type="button">Reset</button>
    </div>
    -->

</div>