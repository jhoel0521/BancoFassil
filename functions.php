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