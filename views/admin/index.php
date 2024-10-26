<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="<?php echo constant('URL') ?>/public/css/style-admin.css">
</head>

<body>

<!-- Mostrar mensajes de sesión -->
<?php $this->showSessionMessages(); ?>
    <header>
        <a href="<?php echo constant('URL') ?>admin/index" class="logo">
            <img src="<?php echo constant('URL') ?>/public/img/gestion.png" alt="Img-gestion">
            <br><span>Task User Flow</span>
        </a>
        <h1>Panel de Administración</h1>
        <nav>
            <ul>
            <li><a href="<?php echo constant('URL') ?>user/create-task">Crear Tarea</a></li>
            <li><a href="<?php echo constant('URL') ?>user/profile">Mi Perfil</a></li>
            <li><a href="<?php echo constant('URL') ?>logout">Cerrar Sesión</a></li>    
            </ul>
        </nav>
    </header>

    <main class="container">
        <h2>Bienvenido, Administrador</h2>
        <p>Desde aquí puedes gestionar usuarios, tareas y categorías.</p>
        <br>
        


        <section>
            <h3>Gestión de Usuarios</h3>
            <p>Administra los usuarios de la aplicación.</p>
            <a href="/TaskUserFlow/admin/userManagement" class="button">Ir a Gestión de Usuarios</a>
        </section>

        <section>
            <h3>Gestión de Categorías</h3>
            <p>Crea, edita o elimina categorías de tareas.</p>
            <a href="/TaskUserFlow/admin/categoryManagement" class="button">Ir a Gestión de Categorías</a>
        </section>

        <section>
            <h3>Gestión de Tareas</h3>
            <p>Administra todas las tareas de los usuarios.</p>
            <a href="/TaskUserFlow/admin/taskManagement" class="button">Ir a Gestión de Tareas</a>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Tu Aplicación de Tareas</p>
    </footer>
</body>

</html>