<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
</head>
<body>
    <h1>Crear Nueva Tarea</h1>
    <form method="POST" action="/TaskUserFlow/task/store">
        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion" required>
        
        <label for="status">Estado:</label>
        <select name="status">
            <option value="pendiente">Pendiente</option>
            <option value="completada">Completada</option>
        </select>
        
        <label for="comment">Comentario:</label>
        <textarea name="comment"></textarea>
        
        <label for="id_category">Categoría:</label>
        <select name="id_category" required>
            <?php if ($categories): ?>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category->id; ?>"><?= $category->name; ?></option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="">No hay categorías disponibles</option>
            <?php endif; ?>
        </select>

        <button type="submit">Crear Tarea</button>
    </form>
</body>
</html>
