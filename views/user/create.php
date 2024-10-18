<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
</head>
<body>
    <h1>CREAR USUARIO</h1>

    <form action="/TaskUserFlow/user/store" method="POST" enctype="multipart/form-data">
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
        <select name="role" id="role" >
            <option value="0">------</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>
        <br>
        <label for="photo">Photo</label>
        <input type="text" name="photo" id="photo">
        <br>
        <button type="submit">Create</button>
    </body>
</html>