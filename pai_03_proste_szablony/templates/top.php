<!DOCTYPE html>
<html lang="pl">
<link rel="stylesheet" href="<?php print(_APP_URL);?>/css/style.css">

<head>
    <meta charset="UTF-8">
    <title> <?php out($page_title); if (!isset($page_title)) {  ?> Tytuł domyślny... <?php } ?> </title>
</head>

<body class="landing is-preload">

    <div id="page-wrapper">

        <section id="banner">
            <h2><b><?php out($page_header); if (!isset($page_header)) {  ?> Tytuł domyślny... <?php } ?></b></h2> </br>
			<p><b><?php out($page_description); if (!isset($page_description)) {  ?> Opis domyślny... <?php } ?></b></p>
            <button class="button primary">Oblicz swój kredyt</button>
		</section>