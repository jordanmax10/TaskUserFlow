<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
</head>

<body>
    <a href="/TaskUserFlow/user/create">Crear Usuario</a>


    <table border="1">
        <thead>
            <tr>
                <th>Id</th>
                <th>Username</th>
                <th>Name</th>
                <th>Role</th>
                <th>Photo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user->getId()); ?></td>
                        <td><?php echo htmlspecialchars($user->getUsername()); ?></td>
                        <td><?php echo htmlspecialchars($user->getName()); ?></td>
                        <td><?php echo htmlspecialchars($user->getRole()); ?></td>
                        <td>
                            <?php if ($user->getPhoto()): ?>
                                <img src="<?php echo htmlspecialchars($user->getPhoto()); ?>" alt="User Photo" width="50">
                            <?php else: ?>
                                No photo
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="/TaskUserFlow/user/edit/<?php echo htmlspecialchars($user->getId()); ?>">Actualizar</a>
                            <a href="/TaskUserFlow/user/delete/<?php echo htmlspecialchars($user->getId()); ?>">Eliminar</a>
                            <a href="/TaskUserFlow/user/show/<?php echo htmlspecialchars($user->getId())?>">Show</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>