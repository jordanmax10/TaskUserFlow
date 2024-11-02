<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoria</title>
    <link rel="stylesheet" href="<?php echo constant('URL') ?>/public/css/style.css">

</head>
<style>
    /* Estilo para el contenedor del color */
    .color-preview {
        width: 50px;
        height: 50px;
        border: 1px solid #ccc;
        margin-top: 10px;
        display: inline-block;
    }
</style>

<body>
    <!-- Mostrar mensajes de sesión -->
    <?php $this->showSessionMessages(); ?>

    <header>
        <a href="<?php echo constant('URL') ?>user/index" class="logo">
            <img src="<?php echo constant('URL') ?>/public/img/gestion.png" alt="Img-gestion">
            <span>Task User Flow</span>
        </a>
        <h1>Editar Categoria: <?php echo htmlspecialchars($category->getName()); ?></h1>
        <nav>
            <ul>
                <li><a href="/TaskUserFlow/admin">Volver al Panel</a></li>
                <li><a href="<?php echo constant('URL') ?>user/profile">Mi Perfil</a></li>
                <li><a href="<?php echo constant('URL') ?>logout">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <form action="<?php echo constant('URL')?>category/update" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($category->getId()); ?>">

            <label for="name">Nombre</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($category->getName()); ?>" required>
            <br>

            <label for="color">Color</label>
            <input type="color" id="color" name="color" value="<?php echo htmlspecialchars($category->getColor()); ?>" required>
            <div class="color-preview" id="color-preview" style="background-color: <?php echo htmlspecialchars($category->getColor()); ?>;"></div>
            <br>

            <input type="submit" value="Guardar">
        </form>

        <button>
            <a href="/TaskUserFlow/admin/categoryManagement">Cancelar</a>
        </button>
    </main>

    <footer>
        <?php require_once __DIR__ . '/../interfaces/footer.php'; ?>
    </footer>

    <script>
        const colorInput = document.getElementById('color');
        const colorPreview = document.getElementById('color-preview');

        colorInput.addEventListener('input', () => {
            colorPreview.style.backgroundColor = colorInput.value;
        });
    </script>

</body>

</html>