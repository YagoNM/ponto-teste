<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arquivo de Ponto</title>
</head>

<body>
    <h1>Enviar o Arquivo de Ponto</h1>

    @if (session('success'))
    <div style="color: green;">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('ponto.upload.handle') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="ponto_file">Selecione o arquivo de ponto (.txt):</label>
            <input type="file" name="ponto_file" id="ponto_file" required>
        </div>
        <button type="submit">Enviar</button>
    </form>
</body>

</html>