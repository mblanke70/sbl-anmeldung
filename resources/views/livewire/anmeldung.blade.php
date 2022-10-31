<div class="mt-3">
    <!--
    <div class="progress mb-3" style="height: 15px;">
        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{ $currentStep*20 }}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    -->
    
    <div class="container d-flex justify-content-center align-items-center my-4">
        <div class="step-wizard">
            <button class="finished" wire:click="step(1)" type="button">1</button>
            <span class="line finished"></span>      
            <button class="{{ $currentStep < 2 ? '' : 'finished' }}" wire:click="step(2)" type="button">2</button>
            <span class="line {{ $currentStep < 2 ? '' : 'finished' }}"></span>
            <button class="{{ $currentStep < 3 ? '' : 'finished' }}" wire:click="step(3)" type="button">3</button>
            <span class="line {{ $currentStep < 3 ? '' : 'finished' }}"></span>
            <button class="{{ $currentStep < 4 ? '' : 'finished' }}" wire:click="step(4)" type="button">4</button>
            <span class="line {{ $currentStep < 4 ? '' : 'finished' }}"></span>
            <button class="{{ $currentStep < 5 ? '' : 'finished' }}" wire:click="step(5)" type="button">5</button>           
        </div>    
    </div>

    <!-- STEP 1 -->
    @include('livewire.step1')

    <!-- STEP 2 -->
    @include('livewire.step2')
    
    <!-- STEP 3 -->
    @include('livewire.step3')
 
    <!-- STEP 4 -->
    @include('livewire.step4')

    <!-- STEP 5 -->
    @include('livewire.step5')
    
    <!-- STEP 6 -->
    @include('livewire.step6')

    <!-- LOG -->
    <div class="row">
    
        <div class="col">
            <div class="alert alert-primary mt-4" role="alert">
                <h4>Schritt 1</h4>
                <dl>
                    <dt>$anrede</dt>
                    <dd>{{ $anrede }}</dd>
                    <dt>$vorname</dt>
                    <dd>{{ $vorname }}</dd>
                    <dt>$nachname</dt>
                    <dd>{{ $nachname }}</dd>
                    <dt>$strasse</dt>
                    <dd>{{ $strasse }}</dd>
                    <dt>$plz</dt>
                    <dd>{{ $zip }}</dd>
                    <dt>$ort</dt>
                    <dd>{{ $ort }}</dd>                    
                    <dt>$email</dt>
                    <dd>{{ $email }}</dd>
                    <dt>$jahrgang</dt>
                    <dd>{{ $jahrgang->id }}</dd>
                    <dt>$ermaessigung</dt>
                    <dd>{{ $ermaessigung }}</dd>
                    <dt>$bescheinigung1</dt>
                    <dd>{{ $bescheinigung1 }}</dd>
                    <dt>$bescheinigung2</dt>
                    <dd>{{ $bescheinigung2 }}</dd>
                </dl>
            </div> 
        </div>
        <div class="col">
            <div class="alert alert-warning mt-4" role="alert">
                <h4>Schritt 2</h4>            
                <dl>
                    <dt>$abfragen</dt>
                    <dd> {{ var_export($abfragen->pluck('id')->toArray()) }} </dd>
                    <dt>$abfrageAntworten</dt>
                    <dd> {{ var_export($abfrageAntworten) }} </dd>
                    <dt>$buecherliste</dt>
                    <dd> {{ var_export($buecherliste->pluck('id')->toArray()) }} </dd>

                </dl>
            </div> 
        </div>
        <div class="col">
            <div class="alert alert-success mt-4" role="alert">
                <h4>Schritt 3</h4>            
                <dl>
                    <dt>$wahlen</dt>
                    <dd> {{ var_export($wahlen) }} </dd>
                    <dt>$leihliste</dt>
                    <dd> {{ var_export($leihliste->pluck('id')->toArray()) }} </dd>
                    <dt>$leihlisteEbooks</dt>
                    <dd> {{ var_export($leihlisteEbooks->pluck('id')->toArray()) }} </dd>
                    <dt>$kaufliste</dt>
                    <dd>{{ var_export($kaufliste->pluck('id')->toArray()) }}</dd>  
                </dl>
            </div> 
        </div>
        <div class="col">
            <div class="alert alert-danger mt-4" role="alert">
                <h4>Schritt 4</h4>
                <dl>
                    <dt>$ebooks</dt>
                    <dd>{{ var_export($ebooks) }}</dd>
                    <dt>$summeLeihen</dt>
                    <dd>{{ $summeLeihen }}</dd>
                    <dt>$summeKaufen</dt>
                    <dd>{{ $summeKaufen }}</dd>
                    <dt>$summeLeihenReduziert</dt>
                    <dd>{{ $summeLeihenReduziert }}</dd>
                </dl>
            </div> 
        </div>
        <div class="col">
            <div class="alert alert-dark mt-4" role="alert">
                <h4>Schritt 5</h4>            
                <dl>
                    <dt>$zustimmung</dt>
                    <dd>{{ $zustimmung }}</dd>
                </dl>
            </div> 
         </div>
    </div>
    
</div>