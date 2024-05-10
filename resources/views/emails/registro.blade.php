<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Bienvenido a Dafne!</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body>
    
    <br>
    <div style="display: flex; align-items: center; justify-content: center;">

        <img src="{{ $message->embed(public_path('img/login.png')) }}" alt="Logo de Dafne" style="width: 100px; height: auto;">
    
        <h1 style="font-size: 24px; margin-left: 10px;">D.A.F.N.E.</h1>
    </div>
    <br>
    
    <p>Hola, <Strong>{{$name}}</Strong>.</p><br>

    <p>Bienvenido a <strong>D.A.F.N.E.</strong> tu plataforma dedicada al 
        <strong>direccionamiento y acompañamiento a la formalización de nuevas empresas</strong>. 
        </p><br>
    
    <p>Tu PIN de verificación de Correo electronico es: <strong>{{ $pin }}</strong>. Este pin lo usarás
        al ingresar por primera vez a nuestro sistema Web. URL: <a href="https://formaliza.hacem.com.co/">Ingresa Aqui</a></p></p>
</body>
</html>
