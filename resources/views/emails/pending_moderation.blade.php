<!DOCTYPE html>
<html>
<head>
    <title>Pendiente de Moderación</title>
</head>
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
    </style>
<body>
<div class="email-container">
    <div style="display: flex; align-items: center; justify-content: center;">

        <img src="{{ $message->embed(public_path('img/login.png')) }}" alt="Logo de Dafne" style="width: 100px; height: auto;">
        <h2 style="font-size: 24px; margin-left: 10px;">D.A.F.N.E.</h2>

    </div>

    <div class="email-header">
        <h1> {{ $type }} pendiente de moderación</h1>
    </div>
    <div class="email-body">
        <p><strong>Descripción:</strong> {{ $description }}</p>
        <p><strong>Usuario:</strong> {{ $nombre }}</p>
        <p><strong>Hora de creación:</strong> {{ $createdAt }}</p>
        <p><strong>Hora de vencimiento:</strong> {{ $expiresAt }}</p>
        <p>Por favor, modere este <strong>{{ $type }}</strong> antes de que expire.</p>
    </div>
    <div class="email-footer">
        <p>Gracias,<br>El equipo de D.A.F.N.E</p>
    </div>
</div>
</body>
</html>
