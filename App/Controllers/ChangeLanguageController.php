<?php
namespace App\Controllers;

use Core\Request;
use Core\Session;

class ChangeLanguageController extends Controller
{
    public function changeLanguage(Request $request, $lang)
    {
        if (isset($lang) && in_array($lang, ['es', 'en'])) {
            Session::set('lang', $lang);
        }

        return redirect(back());
    }
}
