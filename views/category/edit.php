<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoria</title>
</head>
<body>
    <form action="/TaskUserFlow/category/update" method="POST" >
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($category->getId()); ?>">
        
        <label for="name">Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($category->getName()); ?>" required>
        <br>
        <label for="color">Color</label>
        <input type="text" name="color" value="<?php echo htmlspecialchars($category->getColor()); ?>" required>
        <br>
        <input type="submit" value="Save">
    </form>
</body>
</html>
