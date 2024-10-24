<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <form action="<?php echo constant('URL');?>login/authenticate" method="POST"><!-- Apunta al AuthSessionController -->
    <label for="username">Nombre de Usuario:</label>
    <input type="text" name="username" required>
    
    <label for="password">Contraseña:</label>
    <input type="password" name="password" required>
    
    <button type="submit">Iniciar Sesión</button>
</form>

</body>
</html>
