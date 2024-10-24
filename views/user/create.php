<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Tarea</title>
</head>
<body>
    <h1>Crear Nueva Tarea</h1>
    <form action="/task/store" method="POST">
        <label for="title">Título:</label>
        <input type="text" name="title" required>
        <label for="description">Descripción:</label>
        <textarea name="description" required></textarea>
        <input type="submit" value="Crear Tarea">
    </form>
</body>
</html>
