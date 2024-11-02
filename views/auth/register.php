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
        <form action="<?= constant('URL') ?>register" method="POST" enctype="multipart/form-data">
        <label for="username">Username</label>
            <input type="text" name="username" id="username" required pattern="[a-zA-Z0-9_]+" title="El nombre de usuario solo puede contener letras, números y guiones bajos.">
            <br>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required minlength="6" title="La contraseña debe tener al menos 6 caracteres.">
            <br>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" required>
            <br>
            <label for="photo">Photo</label>
            <input type="file" name="photo" id="photo" accept="image/*">
            <br>
            <button type="submit">Register</button>
        </form>
        <a href="<?= constant('URL') ?>login">Login</a>
    </div>
</body>

</html>