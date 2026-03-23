<?php
//Tu już nie ładujemy konfiguracji - sam widok nie będzie już punktem wejścia do aplikacji.
//Wszystkie żądania idą do kontrolera, a kontroler wywołuje skrypt widoku.
include _ROOT_PATH.'/templates/top.php';
?>

<section id="main" class="container">

	<section class="box special">
		<form action="<?php print(_APP_URL);?>/app/credit.php" method="post">
			<legend>Kalkulator Kredytowy:</legend> </br>
			<fieldset>
				<label for="kwota">Kwota (zł): </label>
					<input id="kwota" type="text" name="kwota" value="<?php out($kwota); ?>" />
				<label for="procent">Oprocentowanie (%): </label>
					<select name="procent">
						<option value="2">2</option>
						<option value="4">4</option>
						<option value="6">6</option>
						<option value="8">8</option>
					</select>
				<label for="okres">Okres (lata): </label>
					<input id="okres" type="text" name="okres" value="<?php out($okres); ?>" />
			</fieldset> </br>
			<input type="submit" value="Oblicz" class="pure-button pure-button-primary" />
		</form>	
	</section>

		<?php
		//wyświeltenie listy błędów, jeśli istnieją
		if (isset($messages)) {
			if (count ( $messages ) > 0) {
			echo "<section class='box special' style='border: 2px solid #f88;'><h2>Błędy w formularzu:</h2>";
				foreach ( $messages as $key => $msg ) {
					echo '<li>'.$msg.'</li>';
				}
				echo '</ol>';
			echo "</section>";
			}
		}
		?>

		<?php if (isset($result)){ ?>
		<section class='box special' style='border: 2px solid #09a33a;'><h2>Wynik obliczeń:</h2>
		<?php echo 'Miesięczna rata kredytu wyniesie  '. round($result, 2) . ' zł'; ?>
		</section>
		<?php } ?>

</section>

<section id="cta">

	<h2>Skontaktuj się z nami</h2>
	<p>Wpisz swój adres email, a my skontaktujemy się z tobą najszybciej jak to możliwe</p>

	<form>
		<div class="row gtr-50 gtr-uniform">
			<div class="col-8 col-12-mobilep">
				<input type="email" name="email" id="email" placeholder="email" />
			</div>
			<div class="col-4 col-12-mobilep">
				<input type="submit" value="Wyślij" class="fit" />
			</div>
		</div>
	</form>

</section>

</div>

<?php
include _ROOT_PATH.'/templates/bottom.php';
?>