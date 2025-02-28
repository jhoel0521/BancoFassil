<?php
define('BASE_URL', "/BancoFassil");

/**
 * @param mixed $value Valor a imprimir
 * Imprime el valor de la variable y termina la ejecución del script
 * @return void
 */
function dd(...$value)
{
    // código respuesta HTTP 400
    http_response_code(400);
    echo "<pre>", print_r($value, true), "</pre>";
    //echo json_encode($value);
    die();
}


function route(string $name, $parameters = []): string
{
    $path = \Core\Router::route($name, $parameters) ?? '/';
    return BASE_URL . $path;
}

function asset($path)
{
    $baseUrl = BASE_URL . '/public/';

    // Elimina la barra inicial si existe en el path
    $path = ltrim($path, '/');

    // Retorna la ruta completa al recurso
    return $baseUrl . $path;
}

function traducir(string $key): string
{
    // Obtener el idioma actual o usar 'es' por defecto
    $lang = getLanguage();
    // Verificar si el idioma es válido
    if (!in_array($lang, $GLOBALS['idiomas_disponibles'])) {
        $lang = 'es'; // Usar español por defecto si el idioma no es válido
    }
    $traducciones = $GLOBALS['translations'][$lang];


    // Retornar la traducción o la clave si no existe
    return $traducciones[$key] ?? $key;
}
function getLanguage()
{
    return $_SESSION['lang'] ?? 'es';
}
