<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="<?php echo constant('URL') ?>/public/css/style-auth.css">
</head>

<body>
    <!-- Mostrar mensajes de sesión -->
    <?php $this->showSessionMessages(); ?>

    <div class="container">
        <h1>Iniciar Sesión</h1>
        <form action="<?php echo constant('URL') ?>login" method="POST">
            <label for="username">Usuario:</label>
            <input type="text" name="username" required>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" required>

            <button type="submit">Iniciar Sesión</button>
        </form>

        <p>
            <a href="<?php echo constant('URL') ?>register">Registrarse</a>
        </p>
    </div>
</body>

</html>