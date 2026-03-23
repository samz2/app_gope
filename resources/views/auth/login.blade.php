<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login | GoPe</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a, #020617);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: #0b1220;
            width: 380px;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, .6);
            color: #e5e7eb;
        }

        .login-card h1 {
            text-align: center;
            margin-bottom: 5px;
            font-size: 28px;
        }

        .login-card p {
            text-align: center;
            margin-bottom: 25px;
            font-size: 14px;
            color: #9ca3af;
        }

        label {
            font-size: 13px;
            margin-bottom: 6px;
            display: block;
            color: #cbd5f5;
        }

        input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #334155;
            background: #020617;
            color: #e5e7eb;
            margin-bottom: 16px;
            outline: none;
        }

        input:focus {
            border-color: #22c55e;
        }

        button {
            width: 100%;
            padding: 13px;
            border-radius: 8px;
            border: none;
            background: #22c55e;
            color: #022c22;
            font-weight: bold;
            cursor: pointer;
            transition: .2s;
        }

        button:hover {
            background: #16a34a;
        }

        .error {
            margin-top: 15px;
            text-align: center;
            color: #f87171;
            font-size: 14px;
        }

        footer {
            margin-top: 25px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
        }
    </style>
</head>

<body>

    <form method="POST" action="{{ route('login.post') }}" class="login-card">
        @csrf

        <h1>GoPe</h1>
        <p>Sistema de gestión</p>

        <div class="mb-3">
            <label class="form-label">Usuario</label>
            <input type="text" name="usuario" class="form-control" required>
        </div>

        <label for="password">Contraseña</label>
        <input id="password" type="password" name="password" placeholder="••••••••" required>

        <button type="submit">Ingresar</button>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <footer>
            © {{ date('Y') }} GoPe. Todos los derechos reservados.
        </footer>
    </form>

</body>

</html>