<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tus Tareas</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>

<body>
    <header>
        <h1>Bienvenido, <?php echo $_SESSION['username']; ?></h1>
        <nav>
            <a href="/TaskUserFlow/user/create">Crear Tarea</a>
            <a href="/TaskUserFlow/user/profile">Mi Perfil</a>
            <a href="/TaskUserFlow/logout">Cerrar Sesión</a>
        </nav>
    </header>
    <main>
        <h2>Tus Tareas</h2>
        <ul>

            <?php if (isset($tasks) && is_array($tasks)): ?>
                <?php foreach ($tasks as $task): ?>
                    <li>
                        <a href="/task/show/<?php echo htmlspecialchars($task['id']); ?>"><?php echo $task['title']; ?></a>
                        <a href="/task/edit/<?php echo htmlspecialchars($task['id']); ?>">Editar</a>
                        <a href="/task/delete/<?php echo htmlspecialchars($task['id']); ?>">Eliminar</a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay tareas disponibles.</p>
            <?php endif; ?>

        </ul>
    </main>
</body>

</html>