<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nueva Tarea</title>
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
        <h1>Crear Nueva Tarea</h1>
        <nav>
            <ul>
                <li><a href="<?php echo constant('URL') ?>user/create-task">Crear Tarea</a></li>
                <li><a href="<?php echo constant('URL') ?>user/profile">Mi Perfil</a></li>
                <li><a href="<?php echo constant('URL') ?>logout">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main class="container">
        <form method="POST" action="<?php echo constant('URL') ?>/user/store-task">
            <label for="description">Descripción:</label>
            <input type="text" name="description" required>
            <br>
            <label for="status">Estado:</label>
            <select name="status" required>
                <option value="Pendiente">Pendiente</option>
                <option value="En_proceso">En Progreso</option>
                <option value="Completada">Completada</option>
            </select>
            <br>
            <label for="comment">Comentario:</label>
            <textarea name="comment">Ninguno</textarea>
            <br>
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
            <br>
            <button type="submit">Crear Tarea</button>
        </form>
    </main>
    <br><br>
    <footer>
        <?php require_once __DIR__ . '/../interfaces/footer.php';  ?>
    </footer>
</body>

</html>