<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Información</title>
</head>
<body>

    <h1>Mostrar Información</h1>
    <p>Nombre: <?php echo $user->getName(); ?></p>
    <p>Usuario: <?php echo $user->getUsername(); ?></p>
    <p>Rol: <?php echo $user->getRole(); ?></p>
    <p>Foto: <?php echo $user->getPhoto(); ?></p>

    <a href="/TaskUserFlow/user">Volver</a>
    
</body>
</html>