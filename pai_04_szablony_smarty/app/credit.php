<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';
//załaduj Smarty
require_once _ROOT_PATH.'/lib/smarty/libs/Smarty.class.php';

//pobranie parametrów
function getParams(&$form){
	$form['kwota'] = isset($_REQUEST['kwota']) ? $_REQUEST['kwota'] : null;
	$form['procent'] = isset($_REQUEST['procent']) ? $_REQUEST['procent'] : null;
	$form['okres'] = isset($_REQUEST['okres']) ? $_REQUEST['okres'] : null;	
}

//walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$form,&$infos,&$msgs){

	// sprawdzenie, czy parametry zostały przekazane
	if ( ! (isset($form['kwota']) && isset($form['procent']) && isset($form['okres']))) return false;

	//parametry przekazane zatem
	//nie pokazuj wstępu strony gdy tryb obliczeń (aby nie trzeba było przesuwać)
	// - ta zmienna zostanie użyta w widoku aby nie wyświetlać całego bloku itro z tłem 
	$hide_intro = true;

	$infos [] = 'Przekazano parametry.';

	// sprawdzenie, czy potrzebne wartości zostały przekazane
	if ( $form['kwota'] == "") $msgs [] = 'Nie podano kwoty kredytu';
	if ( $form['okres'] == "") $msgs [] = 'Nie podano okresu kredytu';

	// nie ma sensu walidować dalej gdy brak parametrów
	if ( count($msgs) == 0 ) {
		// sprawdzenie, czy $kwota i $okres są liczbami całkowitymi
		if (! is_numeric( $form['kwota'] )) $msgs [] = 'Kwota kredytu nie jest liczbą całkowitą';
		if (! is_numeric( $form['okres'] )) $msgs [] = 'Okres kredytu nie jest liczbą całkowitą';

		// sprawdzenie, czy $kwota i $okres są wieksze niż 0
		if ( $form['kwota'] <= 0) $msgs [] = 'Kwota kredytu musi być większa niż 0';
		if ( $form['okres'] <= 0) $msgs [] = 'Okres kredytu musi być większy niż 0';
	}

	if (count($msgs) > 0) return false;
	else return true;
}

// wykonaj obliczenia
function process(&$form,&$infos,&$msgs,&$result){
	$infos [] = 'Parametry poprawne. Wykonuję obliczenia.';

	//konwersja parametrów na int
	$form['kwota'] = floatval($form['kwota']);
	$form['procent'] = floatval($form['procent']);
	$form['okres'] = intval($form['okres']);

	$result = obliczRate($form['kwota'],$form['procent'],$form['okres']);
}

//funkcja obliczająca rate kredytu
function obliczRate($kwota, $procent, $okres){
	$oprocentowanie = (($kwota * $procent) / 100) * $okres;
	$wynik = $kwota + $oprocentowanie;

	$miesiac = $okres * 12;

	return $wynik / $miesiac;
}

//inicjacja zmiennych
$form = null;
$infos = array();
$messages = array();
$result = null;

getParams($form);
if ( validate($form,$infos,$messages) ){
	process($form,$infos,$messages,$result);
}

// Przygotowanie danych dla szablonu

$smarty = new Smarty\Smarty();

$smarty->assign('app_url',_APP_URL);
$smarty->assign('root_path',_ROOT_PATH);
$smarty->assign('page_title','Kalkulator kredytowy');
$smarty->assign('page_description','Dzięki temu kalkulatorowi możesz obliczyć ratę swojego kredytu!');
$smarty->assign('page_header','Kalkulator kredytowy');

//pozostałe zmienne niekoniecznie muszą istnieć, dlatego sprawdzamy aby nie otrzymać ostrzeżenia
$smarty->assign('form',$form);
$smarty->assign('result',$result);
$smarty->assign('messages',$messages);
$smarty->assign('infos',$infos);

// Wywołanie szablonu
$smarty->display(_ROOT_PATH.'/app/credit_view.html');