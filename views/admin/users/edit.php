<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="<?php echo constant('URL') ?>/public/css/style-admin.css">
</head>

<body>
    <header>
        <h1>Editar Usuario</h1>
        <nav>
            <a href="/TaskUserFlow/admin">Volver al Panel</a>
            <a href="/TaskUserFlow/logout">Cerrar Sesión</a>
        </nav>
    </header>

    <main>
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
        <a href="/TaskUserFlow/admin/users/userManagement">Cancelar</a>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Tu Aplicación de Tareas</p>
    </footer>
</body>

</html>