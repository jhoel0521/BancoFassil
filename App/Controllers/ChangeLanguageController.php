<?php
namespace App\Controllers;

class ChangeLanguageController extends Controller
{
    public function changeLanguage()
    {
        session_start(); // Asegurar que la sesión está iniciada

        // Verificar si el idioma enviado es válido
        if (isset($_POST['lang']) && in_array($_POST['lang'], ['es', 'en'])) {
            $_SESSION['lang'] = $_POST['lang']; // Guardar idioma en la sesión
        }

        // Redirigir a la página anterior
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
