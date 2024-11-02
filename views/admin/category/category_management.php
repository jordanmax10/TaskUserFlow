<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Categorías</title>
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
        <h1>Gestión de Categorias</h1>
        <nav>
            <ul>
                <li><a href="/TaskUserFlow/admin">Volver al Panel</a></li>
                <li><a href="<?php echo constant('URL') ?>user/profile">Mi Perfil</a></li>
                <li><a href="<?php echo constant('URL') ?>logout">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <h2>Lista de Categorías</h2>
        <br>
        <a href="/TaskUserFlow/category/create" class="button">Agregar Nueva Categoría</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de Categoría</th>
                    <th>Color</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($category->getId()); ?></td>
                            <td><?php echo htmlspecialchars($category->getName()); ?></td>
                            <td style="background-color: <?php echo htmlspecialchars($category->getColor()); ?>;"></td>
                            <td>
                                <a href="/TaskUserFlow/category/edit/<?php echo htmlspecialchars($category->getId()); ?>">Editar</a>
                                <a href="/TaskUserFlow/category/delete/<?php echo htmlspecialchars($category->getId()); ?>">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No hay categorías disponibles.</td>
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