@extends('layouts.main')

@section('content')
<form action="{{ route('credit') }}" method="post">
    @csrf
    <legend>Kalkulator Kredytowy:</legend><br>
    <fieldset>
        <label for="kwota">Kwota (zł): </label>
        <input id="kwota" type="text" name="kwota" value="{{ $form['kwota'] ?? '' }}">

        <label for="procent">Oprocentowanie (%): </label>
        <select name="procent">
            @if(isset($form['procent']) && $form['procent'] !== null)
                <option value="{{ $form['procent'] }}">ponownie: {{ $form['procent'] }}</option>
                <option value="" disabled>---</option>
            @endif
            <option value="2">2</option>
            <option value="4">4</option>
            <option value="6">6</option>
            <option value="8">8</option>
        </select>

        <label for="okres">Okres (lata): </label>
        <input id="okres" type="text" name="okres" value="{{ $form['okres'] ?? '' }}">
    </fieldset><br>

    <input type="submit" value="Oblicz" class="pure-button pure-button-primary">
</form>

{{-- Błędy --}}
@if(isset($messages) && count($messages) > 0)
    <section class="box special" style="border: 2px solid #f88;">
        <h2>Błędy w formularzu:</h2>
        <ul>
            @foreach($messages as $msg)
                <li>{{ $msg }}</li>
            @endforeach
        </ul>
    </section>
@endif

{{-- Infos --}}
@if(isset($infos) && count($infos) > 0)
    <section class="box special" style="border: 2px solid #09a33a;">
        <ul>
            @foreach($infos as $msg)
                <li>{{ $msg }}</li>
            @endforeach
        </ul>
    </section>
@endif

{{-- Wynik --}}
@if(isset($result))
    <section class="box special" style="border: 2px solid #09a33a;">
        <h2>Wynik obliczeń:</h2>
        <span>Miesięczna rata kredytu wyniesie {{ sprintf('%.2f', $result) }} zł.</span>
    </section>
@endif
@endsection

@section('contact')
    <h2>Skontaktuj się z nami</h2>
    <p>Wpisz swój adres email, a my skontaktujemy się z tobą najszybciej jak to możliwe</p>
    <form>
        <div class="row gtr-50 gtr-uniform">
            <div class="col-8 col-12-mobilep">
                <input type="email" name="email" id="email" placeholder="email">
            </div>
            <div class="col-4 col-12-mobilep">
                <input type="submit" value="Wyślij" class="fit">
            </div>
        </div>
    </form>
@endsection

@section('footer')
    <p>Kontakt: credit@calc.pl</p>
@endsection