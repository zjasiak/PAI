@extends('layouts.main')

@section('content')
<h2>Logowanie do systemu</h2>

<form action="{{ route('login') }}" method="post">
    @csrf
    <fieldset>
        <label for="login">Login:</label>
        <input id="login" type="text" name="login" required>

        <label for="pass">Hasło:</label>
        <input id="pass" type="password" name="pass" required>
    </fieldset><br>

    <input type="submit" value="Zaloguj" class="pure-button pure-button-primary">
</form>

@include('partials.messages')
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