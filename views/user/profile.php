<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo constant('URL') ?>/public/css/style.css">
    <title>Profile </title>
</head>

<body>

    <!-- Mostrar mensajes de sesión -->
    <?php $this->showSessionMessages(); ?>

    <header>
        <a href="<?php echo constant('URL') ?>user/index" class="logo">
            <img src="<?php echo constant('URL') ?>/public/img/gestion.png" alt="Img-gestion">
            <br><span>Task User Flow</span>
        </a>
        <h1>Perfil de : <?php echo $_SESSION['username'] ?></h1>
        <nav>
            <ul>
                <li><a href="<?php echo constant('URL') ?>user/create-task">Crear Tarea</a></li>
                <li><a href="<?php echo constant('URL') ?>user/profile">Mi Perfil</a></li>
                <li><a href="<?php echo constant('URL') ?>logout">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">

        <form action="<?php echo constant('URL') ?>/user/update-profile" method="POST" enctype="multipart/form-data">
            <label for="username">UserName</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user->getUsername()); ?>" required>
            <br>
            <label for="password">New Password</label>
            <input type="password" name="password" placeholder="Nueva Contraseña" >
            <br>
            <label for="name">Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user->getName()); ?>" required>
            <br>
            <label for="photo">Photo</label>
            <input type="text" name="photo" value="<?php echo htmlspecialchars($user->getPhoto()); ?>" required>
            <br>
            <input type="submit" value="Save">
        </form>
    </main>
    <br>
    <footer>
        <?php require_once __DIR__ . '/../interfaces/footer.php'; ?>
    </footer>
</body>

</html>