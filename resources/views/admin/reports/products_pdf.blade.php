<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Equipamentos - RentMaster</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 13px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 10px;
        }
        .title {
            font-size: 22px;
            font-weight: bold;
            color: #111827;
            margin: 0;
        }
        .subtitle {
            font-size: 12px;
            color: #6b7280;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #f9fafb;
            border-bottom: 2px solid #e5e7eb;
            color: #374151;
            font-weight: bold;
            text-align: left;
            padding: 10px;
            font-size: 11px;
            text-transform: uppercase;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #f3f4f6;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-disponivel { background-color: #d1fae5; color: #065f46; }
        .badge-alugado { background-color: #fef3c7; color: #92400e; }
        .badge-manutencao { background-color: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>

    <div class="header">
        <h1 class="title">RentMaster – Relatório de Inventário</h1>
        <div class="subtitle">Gerado em {{ date('d/m/Y H:i') }} | Relatório Oficial Operacional</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Equipamento</th>
                <th>Categoria</th>
                <th>Preço Diária</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td style="font-weight: bold; color: #111827;">{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? 'Sem categoria' }}</td>
                    <td>R$ {{ number_format($product->price_per_day, 2, ',', '.') }}</td>
                    <td>
                        <span class="badge badge-{{ $product->status }}">
                            {{ $product->status }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
