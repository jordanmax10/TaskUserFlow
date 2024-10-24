<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>
    <h1>Register User</h1>
    <form action="<?= constant('URL') ?>register" method="POST">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        <br>
        <label for="name">Name</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="role">Role</label>
        <select name="role" id="role">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <br>
        <label for="photo">Photo</label>
        <input type="text" name="photo" id="photo">
        <br>
        <button type="submit">Register</button>
    </form>
    <a href="<?= constant('URL') ?>login">Login</a>
</body>
</html>