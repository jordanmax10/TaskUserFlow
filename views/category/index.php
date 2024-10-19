<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category List</title>
</head>

<body>

<a href="/TaskUserFlow/category/create">Crear Categoria</a>

    <table border="2">
        <thead>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>color</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($category->getId());?></td>
                        <td><?php echo htmlspecialchars($category->getName());?></td>
                        <td><?php echo htmlspecialchars($category->getColor());?></td>

                        <td>
                            <a href="/TaskUserFlow/category/edit/<?php echo htmlspecialchars($category->getId());?>">Actualizar</a>
                            <a href="/TaskUserFlow/category/delete/<?php echo htmlspecialchars($category->getId());?>">Eliminar</a>
                        </td>
                    </tr>

                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td>No Categories Found.</td>
                    <td>No Categories Found.</td>
                    <td>No Categories Found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>