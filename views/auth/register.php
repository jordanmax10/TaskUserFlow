<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    <link rel="stylesheet" href="<?php echo constant('URL') ?>/public/css/style-auth.css">
</head>

<body>

    <!-- Mostrar mensajes de sesión -->
    <?php $this->showSessionMessages(); ?>
    
    <div class="container">
        <h1>Register User</h1>
        <form action="<?= constant('URL') ?>register" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
            <br>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            <br>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" required>
            <br>
            <label for="photo">Photo</label>
            <input type="text" name="photo" id="photo">
            <br>
            <button type="submit">Register</button>
        </form>
        <a href="<?= constant('URL') ?>login">Login</a>
    </div>
</body>

</html>