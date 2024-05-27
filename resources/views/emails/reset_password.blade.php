<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Restablecer Contraseña</title>
    <style>
           .email-container {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        .email-header, .email-footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .email-body {
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            font-size: 16px;
            color: #fff;
            background-color: #ff6527;
            text-decoration: none;
            border-radius: 5px;
        }
        .container-button{
            text-align: center;
            aling-items:center;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div style="display: flex; align-items: center; justify-content: center;">

            <img src="{{ $message->embed(public_path('img/login.png')) }}" alt="Logo de Dafne" style="width: 100px; height: auto;">

            <h2 style="font-size: 24px; margin-left: 10px;">D.A.F.N.E.</h2>
        </div>
        <div class="email-header">
            <h1>Restablecer Contraseña</h1>
        </div>
        <div class="email-body">
            <p>Hola,</p>
            <p>Recibiste este correo porque solicitaste restablecer tu contraseña. Haz clic en el botón de abajo para completar el proceso:</p>
            <div class="container-button" >
                <a href="{{ url('password/reset', $token) }}?email={{ urlencode($email) }}" class="button">Restablecer Contraseña</a>
            </div><br>
            <p>Si no solicitaste restablecer tu contraseña, no es necesario realizar ninguna acción.</p>
        </div>
        <div class="email-footer">
            <p>Gracias,<br>El equipo de D.A.F.N.E</p>
        </div>
    </div>
</body>
</html>
