<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nueva Tarea</title>
    <link rel="stylesheet" href="/public/css/style.css"> <!-- Estilos opcionales -->
</head>
<body>
    <h1>Crear Nueva Tarea</h1>
    <form method="POST" action="/TaskUserFlow/task/store">
        <label for="description">Descripción:</label>
        <input type="text" name="description" required>

        <label for="status">Estado:</label>
        <select name="status" required>
            <option value="pending">Pendiente</option>
            <option value="in_progress">En Progreso</option>
            <option value="completed">Completada</option>
        </select>

        <label for="comment">Comentario:</label>
        <textarea name="comment"></textarea>

        <input type="hidden" name="id_user" value="<?= htmlspecialchars($user->getId()); ?>"> <!-- ID de usuario oculto -->

        <label for="id_category">Categoría:</label>
        <select name="id_category" required>
            <?php if ($categories && is_array($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= htmlspecialchars($category->getId()); ?>"><?= htmlspecialchars($category->getName()); ?></option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="">No hay categorías disponibles</option>
            <?php endif; ?>
        </select>

        <button type="submit">Crear Tarea</button>
    </form>
</body>
</html>
