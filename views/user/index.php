<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tus Tareas</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>

<body>
    <header>
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
        <nav>
            <ul>
                <li><a href="/TaskUserFlow/task/create">Crear Tarea</a></li>
                <li><a href="/TaskUserFlow/user/profile">Mi Perfil</a></li>
                <li><a href="/TaskUserFlow/logout">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <h2>Tus Tareas</h2>
        <table>
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Comentario</th>
                    <th>ID Usuario</th>
                    <th>ID Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($tasks) && is_array($tasks) && count($tasks) > 0): ?>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($task->getDescription()); ?></td>
                            <td><?php echo htmlspecialchars($task->getStatus()); ?></td>
                            <td><?php echo htmlspecialchars($task->getComment()); ?></td>
                            <td><?php echo htmlspecialchars($task->getIdUser()); ?></td>
                            <td><?php echo htmlspecialchars($task->getIdCategory()); ?></td>
                            <td>
                                <a href="/task/edit/<?php echo htmlspecialchars($task->getId()); ?>">Editar</a>
                                <a href="/task/delete/<?php echo htmlspecialchars($task->getId()); ?>" 
                                   onclick="return confirm('¿Estás seguro de que quieres eliminar esta tarea?');">Eliminar</a>
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
