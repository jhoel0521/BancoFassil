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
/**
 * Retorna una vista
 */
function view($view, $data = [])
{
    extract($data);
    
    $viewPath = str_replace('.', DIRECTORY_SEPARATOR, $view);
    $path = BASE_ROUTE . 'resources' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . $viewPath . '.view.php';
    if (file_exists($path)) {
        require_once $path;
    } else {
        die("Error: La vista '{$view}' no existe en '{$path}'");
    }
}

function route($name) {
    $path = \Core\Router::route($name) ?? '/';
    return BASE_URL . $path;
}
function redirect($url) {
    if (!headers_sent()) {
        header("Location: " . BASE_URL . $url);
    }else{
        // Fallback con JavaScript si las cabeceras ya fueron enviadas
        echo '<script>window.location.href="'.BASE_URL.$url.'"</script>';
    }
    exit();  
}

function asset($path) {
    $baseUrl = BASE_URL.'/public/';

    // Elimina la barra inicial si existe en el path
    $path = ltrim($path, '/');

    // Retorna la ruta completa al recurso
    return $baseUrl . $path;
}
