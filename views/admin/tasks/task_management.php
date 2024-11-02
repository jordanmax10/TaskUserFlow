<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Tareas</title>
    <link rel="stylesheet" href="<?php echo constant('URL') ?>/public/css/style-admin.css">
</head>

<body>
    <!-- Mostrar mensajes de sesión -->
    <?php $this->showSessionMessages(); ?>

    <header>
        <a href="<?php echo constant('URL') ?>user/index" class="logo">
            <img src="<?php echo constant('URL') ?>/public/img/gestion.png" alt="Img-gestion">
            <span>Task User Flow</span>
        </a>
        <h1>Gestión de Tareas</h1>
        <nav>
            <ul>
                <li><a href="/TaskUserFlow/admin">Volver al Panel</a></li>
                <li><a href="<?php echo constant('URL') ?>user/profile">Mi Perfil</a></li>
                <li><a href="<?php echo constant('URL') ?>logout">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <h2>Lista de Tareas</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <!-- <th>Título</th> -->
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Usuario</th>
                    <th>Categoria</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($tasks)): ?>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td data-label="ID"><?php echo htmlspecialchars($task->getId()); ?></td>
                            <td data-label="Descripción"><?php echo htmlspecialchars($task->getDescription()); ?></td>
                            <td data-label="Estado"><?php echo htmlspecialchars($task->getStatus()); ?></td>
                            <td data-label="Usuario"><?php echo htmlspecialchars($task->getUserName()); ?></td>
                            <td data-label="Categoría" style="background-color: <?php echo htmlspecialchars($task->getCategoryColor()); ?>;">
                                <?php echo htmlspecialchars($task->getCategoryName()); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No hay tareas disponibles.</td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
    </main>

    <footer>
        <?php require_once __DIR__ . '/../../interfaces/footer.php'; ?>
    </footer>
</body>

</html>