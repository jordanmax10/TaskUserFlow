<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tus Tareas</title>
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
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
        <nav>
            <ul>
                <li><a href="<?php echo constant('URL') ?>user/create-task">Crear Tarea</a></li>
                <li><a href="<?php echo constant('URL') ?>user/profile">Mi Perfil</a></li>
                <li><a href="<?php echo constant('URL') ?>logout">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <h2>Tus Tareas</h2>
        <table>
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Comentario</th>
                    <th>Categoría</th>
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
                            <td><?php echo htmlspecialchars($task->getCategoryName()); ?></td>
                            <td>
                                <a href="<?php echo constant('URL') ?>user/edit-task/<?php echo htmlspecialchars($task->getId()); ?>">Editar</a>
                                <a href="<?php echo constant('URL') ?>user/delete-task/<?php echo htmlspecialchars($task->getId()); ?>"
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
        <?php require_once __DIR__ . '/../interfaces/footer.php';  ?>
    </footer>
</body>

</html>