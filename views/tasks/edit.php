<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
</head>

<body>
    <h1>Editar Tarea: <?php echo htmlspecialchars($task->getDescripcion()); ?></h1>

    <form method="POST" action="/tasks/update">
        <input type="hidden" name="id" value="<?php echo $task->getId(); ?>">

        <label for="descripcion">Descripción:</label>
        <input type="text" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($task->getDescripcion()); ?>" required>

        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="pendiente" <?php echo $task->getStatus() === 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
            <option value="completada" <?php echo $task->getStatus() === 'completada' ? 'selected' : ''; ?>>Completada</option>
        </select>

        <label for="comment">Comentario:</label>
        <textarea id="comment" name="comment"><?php echo htmlspecialchars($task->getComment()); ?></textarea>

        <label for="id_category">Categoría:</label>
        <select id="id_category" name="id_category" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category->getId(); ?>" <?php echo $category->getId() === $task->getIdCategory() ? 'selected' : ''; ?>><?php echo htmlspecialchars($category->getName()); ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Actualizar Tarea</button>
    </form>

    <a href="/tasks/index">Volver a la lista de tareas</a>


</body>

</html>