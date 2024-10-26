<?php

class Controller
{

    protected function render($view, $data = [])
    {
        $filePath = __DIR__ . '/../views/' . $view . '.php';
        if (file_exists($filePath)) {
            // Extraer los datos para que sean accesibles como variables en la vista
            extract($data);
            require_once $filePath;
        } else {
            http_response_code(404); //Not Found
            throw new Exception("La vista $view no se pudo encontrar.");
        }
    }

    protected function redirectWithMessage($message, $redirectTo, $type = 'error')
    {
        $_SESSION["{$type}_message"] = $message;
        header('Location: ' . constant('URL') . $redirectTo);
        exit();
    }

    protected function showSessionMessages()
    {
        if (isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success" id="success-message">' . htmlspecialchars($_SESSION['success_message']) . '</div>';
            unset($_SESSION['success_message']);
        }

        if (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger" id="error-message">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
            unset($_SESSION['error_message']);
        }

        // JavaScript para ocultar el mensaje después de 3 segundos
        echo '<script>
            setTimeout(function() {
                var successMsg = document.getElementById("success-message");
                var errorMsg = document.getElementById("error-message");
                if (successMsg) successMsg.style.display = "none";
                if (errorMsg) errorMsg.style.display = "none";
            }, 2000); // 2000 ms = 2 segundos
          </script>';
    }
}
