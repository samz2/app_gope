<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Usuario creado</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f3f4f6; padding:20px;">
    <div style="max-width:600px; background:#fff; padding:20px; border-radius:8px;">
        <h2>¡Bienvenido/a a GoPe! 👋</h2>

        <p>Hola <strong>{{ $user->name }}</strong>,</p>

        <p>Tu cuenta ha sido creada correctamente.</p>

        <p><strong>Datos de acceso:</strong></p>
        <ul>
            <li>Email: {{ $user->email }}</li>
            <li>Contraseña: {{ $password }}</li>
        </ul>

        <p>Puedes iniciar sesión desde el sistema.</p>
        <p>Te recomendamos cambiar tu contraseña al ingresar.</p>

        <br>
        <p>Saludos,<br><strong>Equipo GoPe</strong></p>
    </div>
</body>

</html>