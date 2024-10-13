<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <form action="/TaskUserFlow/user/update" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user->getId()); ?>">
        <label for="username">UserName</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user->getUsername()); ?>">
        <br>
        <label for="password">New Password</label>
        <input type="password" name="password" id="password" placeholder="Nueva Contraseña">
        <br>
        <label for="name">Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($user->getName()); ?>">
        <br>
        <label for="role">Role</label>
        <span><?php echo htmlspecialchars($user->getRole()); ?></span>
        <input type="hidden" name="role" value="<?php echo htmlspecialchars($user->getRole()); ?>">
        <br>
        <label for="photo">Photo</label>
        <input type="text" name="photo" value="<?php echo htmlspecialchars($user->getPhoto()); ?>">
        <br>
        <input type="submit" value="Save">
    </form>
</body>
</html>
