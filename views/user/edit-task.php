<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="<?php echo constant('URL') ?>/public/css/style.css">
</head>

<body>

    <!-- Mostrar mensajes de sesión -->
    <?php $this->showSessionMessages(); ?>


    <header>
        <a href="<?php echo constant('URL') ?>user/index" class="logo">
            <img src="<?php echo constant('URL') ?>/public/img/gestion.png" alt="Img-gestion">
            <br><span>Task User Flow</span>
        </a>
        <h1>Editar Tarea: <?php echo htmlspecialchars($task->getDescription()); ?></h1>
        <nav>
            <ul>
                <li><a href="<?php echo constant('URL') ?>user/create-task">Crear Tarea</a></li>
                <li><a href="<?php echo constant('URL') ?>user/profile">Mi Perfil</a></li>
                <li><a href="<?php echo constant('URL') ?>logout">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main class="container">
        <form method="POST" action="<?php echo constant('URL') ?>user/update-task">
            <input type="hidden" name="id" value="<?php echo $task->getId(); ?>">

            <label for="description">Descripción:</label>
            <input type="text" id="description" name="description" value="<?php echo htmlspecialchars($task->getDescription()); ?>" required>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="">--Seleccionar--</option>
                <option value="Pendiente" <?php echo $task->getStatus() === 'Pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                <option value="En_Proceso" <?php echo $task->getStatus() === 'En_Proceso' ? 'selected' : ''; ?>>En proceso</option>
                <option value="Completada" <?php echo $task->getStatus() === 'Completada' ? 'selected' : ''; ?>>Completada</option>
            </select>

            <label for="comment">Comentario:</label>
            <textarea id="comment" name="comment"><?php echo htmlspecialchars($task->getComment()); ?></textarea>

            <label for="id_category">Categoría:</label>
            <select id="id_category" name="id_category" required>
                <option value="">--Seleccionar--</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category->getId(); ?>" <?php echo $category->getId() === $task->getIdCategory() ? 'selected' : ''; ?>><?php echo htmlspecialchars($category->getName()); ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Actualizar Tarea</button>
        </form>
    </main>
    <footer>
        <?php require_once __DIR__ . '/../interfaces/footer.php'; ?>
    </footer>

</body>

</html>