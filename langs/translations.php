<?php
$GLOBALS['idiomas_disponibles'] = ['es', 'en'];
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$lang = getLanguage();

if (!in_array($lang, $GLOBALS['idiomas_disponibles'])) {
    $lang = 'es';
}

$translations = require $lang . '.php';
$GLOBALS['translations'][$lang] = $translations;