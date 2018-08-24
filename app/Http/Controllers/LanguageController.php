<?php

namespace App\Http\Controllers;

use Config;

class LanguageController extends Controller
{
    public function switchLang($lang)
    {
        //in_array para cuando tengo solo en, es sin valores
        if (array_key_exists($lang, Config::get('app.available_locale'))) {
            // . el nombre de la variable available_locale con eso debo tener el en y es con los valores y 
            $url = url()->previous();
            //captura la url  
            //ejem:http://localhost:8000/en/home
            $url_explode = explode("/", $url);
// a la url capturada le divide como un array
            $url_explode[3] = $lang;
            //le pone en la posiscion 3 del siguiente lenguaje
            $redir = implode('/', $url_explode);
            //une el array separado con "/"
//redirect to para enviar toda la url
            return redirect()->to($redir);
        } else {
            return back();
        }
    }
}
