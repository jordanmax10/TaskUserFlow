<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Categorías</title>
    <link rel="stylesheet" href="<?php echo constant('URL')?>/public/css/style-admin.css">
</head>

<body>
    <header>
        <h1>Gestión de Categorías</h1>
        <nav>
            <a href="/TaskUserFlow/admin">Volver al Panel</a>
            <a href="/TaskUserFlow/logout">Cerrar Sesión</a>
        </nav>
    </header>

    <main>
        <h2>Lista de Categorías</h2>
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
        <p>&copy; <?php echo date("Y"); ?> Tu Aplicación de Tareas</p>
    </footer>
</body>

</html>
