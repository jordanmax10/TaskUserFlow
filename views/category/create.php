<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar la Categoria</title>
</head>

<body>
    <h1>CREAR CATEGORIA</h1>

    <form action="/TaskUserFlow/category/store" method="POST" enctype="multipart/form-data">

        <label for="name">Name</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="color">color</label>
        <input type="text" name="color" id="color" required>
        <br>
        <button type="submit">Create</button>
</body>

</html>