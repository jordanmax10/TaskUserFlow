<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Tareas</title>
    <link rel="stylesheet" href="<?php echo constant('URL')?>/public/css/style-admin.css">
</head>

<body>
    <header>
        <h1>Gestión de Tareas</h1>
        <nav>
            <a href="/TaskUserFlow/admin">Volver al Panel</a>
            <a href="/TaskUserFlow/logout">Cerrar Sesión</a>
        </nav>
    </header>

    <main>
        <h2>Lista de Tareas</h2>
        <a href="/TaskUserFlow/task/create" class="button">Agregar Nueva Tarea</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <!-- <th>Título</th> -->
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>ID Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($tasks)): ?>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($task->getId()); ?></td>
                            <td><?php echo htmlspecialchars($task->getDescription()); ?></td>
                            <td><?php echo htmlspecialchars($task->getStatus()); ?></td>
                            <td><?php echo htmlspecialchars($task->getIdUser()); ?></td>
                            <td>
                                <a href="/TaskUserFlow/task/edit/<?php echo htmlspecialchars($task->getId()); ?>">Editar</a>
                                <a href="/TaskUserFlow/task/delete/<?php echo htmlspecialchars($task->getId()); ?>">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No hay tareas disponibles.</td>
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
