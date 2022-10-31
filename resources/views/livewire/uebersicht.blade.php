<div class="pt-4">
                
    <table class="table table-striped"">
        <thead>
            <tr>
                <th>Titel</th> 
                <th>Fach</th>
                <th>ISBN</th>
                <th>Verlag</th>
                <th>Leihpreis</th>
                <th>E-Book</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($this->leihliste as $bt)
                <tr>
                    <td scope="row">{{ $bt->buchtitel->titel }}</td>
                    <td>{{ $bt->buchtitel->fach->name }}</td>
                    <td>{{ $bt->buchtitel->isbn }}</td>
                    <td>{{ $bt->buchtitel->verlag }}</td>
                    <td class="text-right">{{ number_format($bt->leihpreis, 2, ',', '') }} €</td>
                    <td class="text-right">
                        @isset($ebooks)
                            @if(in_array($bt->id, array_keys($ebooks))) 
                                {{ number_format($bt->ebook, 2, ',', '') }} € 
                            @endif
                        @endisset
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <h6>
        Die Summe der
        @switch($this->ermaessigung)
            @case(1) <span style="color: red">um 20% ermäßigten</span> @break
            @case(2) <span style="color: red">um 100% ermäßigten</span> @break
        @endswitch
        Leihgebühren beträgt {{ number_format($this->summeLeihenReduziert, 2, ',', '') }} €.
    </h6>
            
</div>

<div class="pt-4">            
    
    <p>Die hier aufgeführten Bücher kaufen Sie sich selbst. Es findet keine Sammelbestellung von Seiten der Schule statt.</p>
    
        <table class="table table-striped"">
            <thead>
                <tr>
                    <th>Titel</th> 
                    <th>ISBN</th>
                    <th>Verlag</th>
                    <th>Preis</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($this->kaufliste as $bt)
                    <tr>
                        <td scope="row">{{ $bt->buchtitel->titel }}</td>
                        <td>{{ $bt->buchtitel->isbn }}</td>
                        <td>{{ $bt->buchtitel->verlag }}</td>
                        <td>{{ number_format($bt->kaufpreis, 2, ',', '') }} €</td>
                    </tr>
                @endforeach

            </tbody>

        </table> 

        <h6>Die Summe der Kaufpreise beträgt {{ number_format($summeKaufen, 2, ',', '') }} €.</h6>

</div>