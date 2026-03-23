<?php
require_once dirname(__FILE__).'/../config.php';

// KONTROLER strony kalkulatora

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

//pobranie parametrów
function getParams(&$kwota,&$procent,&$okres){
	$kwota = isset($_REQUEST['kwota']) ? $_REQUEST['kwota'] : null;
	$procent = isset($_REQUEST['procent']) ? $_REQUEST['procent'] : null;
	$okres = isset($_REQUEST['okres']) ? $_REQUEST['okres'] : null;	
}

//walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$kwota,&$procent,&$okres,&$messages){
	// sprawdzenie, czy parametry zostały przekazane
	if ( ! (isset($kwota) && isset($procent) && isset($okres))) {
		// sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
		// teraz zakładamy, ze nie jest to błąd. Po prostu nie wykonamy obliczeń
		return false;
	}

	// sprawdzenie, czy potrzebne wartości zostały przekazane
	if ( $kwota == "") {
		$messages [] = 'Nie podano kwoty kredytu';
	}
	if ( $okres == "") {
		$messages [] = 'Nie podano okresu kredytu';
	}

	// nie ma sensu walidować dalej gdy brak parametrów
	if (count ( $messages ) != 0) return false;
	
	// sprawdzenie, czy $kwota i $okres są liczbami całkowitymi
	if (! is_numeric( $kwota )) {
		$messages [] = 'Kwota kredytu nie jest liczbą całkowitą';
	}
	
	if (! is_numeric( $okres )) {
		$messages [] = 'Okres kredytu nie jest liczbą całkowitą';
	}

	// sprawdzenie, czy $kwota i $okres są wieksze niż 0
	if ($kwota <= 0) {
		$messages [] = 'Kwota kredytu musi być większa niż 0';
	}
	if ($okres <= 0) {
		$messages [] = 'Okres kredytu musi być większy niż 0';
	}

	if (count ( $messages ) != 0) return false;
	else return true;
}

function process(&$kwota,&$procent,&$okres,&$messages,&$result){
	global $role;

	//konwersja parametrów na int
	$kwota = floatval($kwota);
	$procent = floatval($procent);
	$okres = intval($okres);

	$result = obliczRate($kwota,$procent,$okres);
}

//funkcja obliczająca rate kredytu
function obliczRate(&$kwota, &$procent, &$okres){
	$oprocentowanie = (($kwota * $procent) / 100) * $okres;
	$wynik = $kwota + $oprocentowanie;

	$miesiac = $okres * 12;

	return $wynik / $miesiac;
}

//definicja zmiennych kontrolera
$kwota = null;
$procent = null;
$okres = null;
$result = null;
$messages = array();

//pobierz parametry i wykonaj zadanie jeśli wszystko w porządku
getParams($kwota,$procent,$okres);
if ( validate($kwota,$procent,$okres,$messages) ) { // gdy brak błędów
	process($kwota,$procent,$okres,$messages,$result);
}

// Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages,$x,$y,$operation,$result)
//   będą dostępne w dołączonym skrypcie

$page_title = 'Kalkulator kredytowy';
$page_description = 'Dzięki temu kalkulatorowi możesz obliczyć ratę swojego kredytu!';
$page_header = 'Kalkulator kredytowy';
$page_footer = 'Kontakt: credit@calc.pl';

include 'credit_view.php';