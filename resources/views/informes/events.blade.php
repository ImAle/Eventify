<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; }
        .title { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f4f4f4; }
        img { max-width: 100px; height: auto; }
    </style>
</head>
<body>
    <h1 class="title">{{ $user->name }}</h1>
    <table>
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Título</th>
                <th>Organizador</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
            <tr>
                <td><img src="{{ public_path('storage/' . $event->image_url) }}" alt="Imagen Evento"></td>
                <td>{{ $event->title }}</td>
                <td>{{ $event->organizer?->name }}</td>
                <td>{{ \Carbon\Carbon::parse($event->pivot->registered_at)->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
