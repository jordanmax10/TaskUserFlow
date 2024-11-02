<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="<?php echo constant('URL') ?>/public/css/style.css">

</head>

<body>
    <!-- Mostrar mensajes de sesión -->
    <?php $this->showSessionMessages(); ?>

    <header>
        <a href="<?php echo constant('URL') ?>user/index" class="logo">
            <img src="<?php echo constant('URL') ?>/public/img/gestion.png" alt="Img-gestion">
            <span>Task User Flow</span>
        </a>
        <h1>Editar Usuario: <?php echo htmlspecialchars($user->getName()); ?></h1>
        <nav>
            <ul>
                <li><a href="/TaskUserFlow/admin">Volver al Panel</a></li>
                <li><a href="<?php echo constant('URL') ?>user/profile">Mi Perfil</a></li>
                <li><a href="<?php echo constant('URL') ?>logout">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <br>
        <form action="<?php echo constant('URL') ?>admin/update" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user->getId()); ?>">
            <label for="username">Nombre de Usuario</label>
            <input type="text" name="username" id="username" value="<?= htmlspecialchars($user->getUsername()) ?>" required>

            <br>
            <label for="password">New Password</label>
            <input type="password" name="password" placeholder="Nueva Contraseña">
            <br>
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($user->getName()) ?>" required>


            <label for="role">Rol</label>
            <select name="role" id="role">
                <option value="user" <?= $user->getRole() === 'user' ? 'selected' : '' ?>>User</option>
                <option value="admin" <?= $user->getRole() === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
            <br>
            <label for="photo">Foto</label>
            <input type="text" name="photo" id="photo" value="<?= htmlspecialchars($user->getPhoto()) ?>" required>


            <button type="submit">Guardar Cambios</button>
        </form>
        <a href="/TaskUserFlow/admin/users/userManagement">Cancelar</a><br>
    </main>

    <footer>
        <?php require_once __DIR__ . '/../../interfaces/footer.php'; ?>
    </footer>
</body>

</html>