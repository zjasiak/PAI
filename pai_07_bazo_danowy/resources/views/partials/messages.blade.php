@if(session('error'))
    <section class="box special" style="border: 2px solid #f88;">
        <ul><li>{{ session('error') }}</li></ul>
    </section>
@endif

@if(session('info'))
    <section class="box special" style="border: 2px solid #09a33a;">
        <ul><li>{{ session('info') }}</li></ul>
    </section>
@endif

@if(isset($messages) && count($messages) > 0)
    <section class="box special" style="border: 2px solid #f88;">
        <ul>
            @foreach($messages as $msg)
                <li>{{ $msg }}</li>
            @endforeach
        </ul>
    </section>
@endif

@if(isset($infos) && count($infos) > 0)
    <section class="box special" style="border: 2px solid #09a33a;">
        <ul>
            @foreach($infos as $msg)
                <li>{{ $msg }}</li>
            @endforeach
        </ul>
    </section>
@endif