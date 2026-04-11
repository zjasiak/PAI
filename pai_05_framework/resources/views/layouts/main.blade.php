<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="{{ $page_description ?? 'Opis domyślny' }}">
    <title>{{ $page_title ?? 'Tytuł domyślny' }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="landing is-preload">

<div id="page-wrapper">

    <section id="banner">
        <h2><b>{{ $page_header ?? 'Tytuł domyślny' }}</b></h2><br>
        <p><b>{{ $page_description ?? 'Opis domyślny' }}</b></p>
        <button class="button primary">Oblicz swój kredyt</button>
    </section>

    <section id="main" class="container">
        <section class="box special">
            @yield('content')
        </section>
    </section>

    <section id="cta">
        @yield('contact')
    </section>

    <footer id="footer">
        <p>@yield('footer')</p>
        <ul class="copyright">
            <li>&copy; zjasiak. All rights reserved.</li>
            <li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
        </ul>
    </footer>

</div>

</body>
</html>