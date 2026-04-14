<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreditController extends Controller
{
    public function credit(Request $request)
    {
        $form = [
            'kwota' => $request->get('kwota'),
            'procent' => $request->get('procent'),
            'okres' => $request->get('okres'),
        ];

        $messages = [];
        $infos    = [];
        $result   = null;

        // metoda POST = przetwarzamy formularz
        if ($request->isMethod('post')) {

            $infos[] = 'Przekazano parametry.';

            // walidacja
            if (empty($form['kwota']))   $messages[] = 'Nie podano kwoty kredytu';
            if (empty($form['okres']))   $messages[] = 'Nie podano okresu kredytu';

            if (empty($messages)) {
                if (!is_numeric($form['kwota'])) $messages[] = 'Kwota kredytu nie jest liczbą całkowitą';
                if (!is_numeric($form['okres'])) $messages[] = 'Okres kredytu nie jest liczbą całkowitą';

                if ($form['kwota'] <= 0) $messages[] = 'Kwota kredytu musi być większa niż 0';
                if ($form['okres'] <= 0) $messages[] = 'Okres kredytu musi być większy niż 0';
            }

            // obliczenia gdy wszystko dobrze
            if (empty($messages)) {
                $infos[] = 'Parametry poprawne. Wykonuję obliczenia.';

                $kwota = (float) $form['kwota'];
                $procent = (float) $form['procent'];
                $okres = (int)   $form['okres'];

                // Ograniczenie operacji według roli
                $userRole = session('user.role');

                if ($kwota > 10000) {
                    if (in_array($userRole, ['admin'])) {
                        $result = $this->obliczRate($kwota, $procent, $okres);
                    } else {
                        $messages[] = 'Tylko administrator może obliczyć ratę kredytu dla kwoty wyższej niż 10 000 zł!';
                    }
                } else {
                    $result = $this->obliczRate($kwota, $procent, $okres);
                }
            }
        }

        return view('credit', [
            'form' => $form,
            'messages' => $messages,
            'infos' => $infos,
            'result' => $result,
            'page_title' => 'Kalkulator kredytowy',
            'page_description' => 'Dzięki temu kalkulatorowi możesz obliczyć ratę swojego kredytu!',
            'page_header' => 'Kalkulator kredytowy',
        ]);
    }

    private function obliczRate($kwota, $procent, $okres)
    {
        $oprocentowanie = (($kwota * $procent) / 100) * $okres;
        $wynik = $kwota + $oprocentowanie;
        $miesiac = $okres * 12;

        return $wynik / $miesiac;
    }
}