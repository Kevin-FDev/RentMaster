<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lembrete de Devolução</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { background-color: #ffffff; padding: 30px; border-radius: 8px; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h1 { color: #DC2626; font-size: 22px; }
        .details { margin: 20px 0; padding: 15px; background-color: #FEF2F2; border-left: 4px solid #DC2626; border-radius: 4px; }
        .details p { margin: 10px 0; font-size: 16px; color: #374151; }
        .footer { margin-top: 30px; font-size: 12px; color: #9CA3AF; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Atenção! Prazo de devolução se aproximando ⏰</h1>
        <p>Olá! Este é um lembrete amigável de que o prazo do seu aluguel está terminando.</p>

        <div class="details">
            <p><strong>📦 Equipamento:</strong> {{ $rentalName }}</p>
            <p><strong>📅 Data de Devolução:</strong> {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }} (em 2 dias)</p>
        </div>

        <p>Por favor, certifique-se de organizar a devolução do equipamento dentro do prazo para evitar transtornos.</p>

        <div class="footer">
            RentMaster Locações &copy; {{ date('Y') }}
        </div>
    </div>
</body>
</html>
