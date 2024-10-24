<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <form action="<?php echo constant('URL')?>login" method="POST">
        <label for="username">Usuario:</label>
        <input type="text" name="username" required>
        
        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>
        
        <input type="submit" value="Iniciar Sesión">
    </form>
</body>
</html>
