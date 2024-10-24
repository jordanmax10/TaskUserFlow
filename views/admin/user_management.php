<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="<?php echo constant('URL')?>/public/css/style-admin.css">
</head>

<body>
    <header>
        <h1>Gestión de Usuarios</h1>
        <nav>
            <a href="/TaskUserFlow/admin">Volver al Panel</a>
            <a href="/TaskUserFlow/logout">Cerrar Sesión</a>
        </nav>
    </header>

    <main>
        <h2>Lista de Usuarios</h2>
        <a href="/TaskUserFlow/user/create" class="button">Agregar Nuevo Usuario</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de Usuario</th>
                    <th>Nombre</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user->getId()); ?></td>
                            <td><?php echo htmlspecialchars($user->getUsername()); ?></td>
                            <td><?php echo htmlspecialchars($user->getName()); ?></td>
                            <td><?php echo htmlspecialchars($user->getRole()); ?></td>
                            <td>
                                <a href="/TaskUserFlow/user/edit/<?php echo htmlspecialchars($user->getId()); ?>">Editar</a>
                                <a href="/TaskUserFlow/user/delete/<?php echo htmlspecialchars($user->getId()); ?>">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No hay usuarios disponibles.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Tu Aplicación de Tareas</p>
    </footer>
</body>

</html>
