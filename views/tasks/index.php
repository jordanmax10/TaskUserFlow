<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
</head>

<body>
    <h1>Tareas de <?php echo htmlspecialchars($user['username']); ?></h1>
    <a href="/tasks/create">Create Task</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Status</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?php echo htmlspecialchars($task->getId()); ?></td>
                    <td><?php echo htmlspecialchars($task->getDescripcion()); ?></td>
                    <td><?php echo htmlspecialchars($task->getStatus()); ?></td>
                    <td><?php echo htmlspecialchars($task->getCategoryName()); ?></td>
                    <td>
                        <a href="/tasks/edit/<?php echo $task->getId(); ?>">Editar</a>
                        <a href="/tasks/delete/<?php echo $task->getId(); ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="/tasks/create">Agregar Nueva Tarea</a>


</body>

</html>