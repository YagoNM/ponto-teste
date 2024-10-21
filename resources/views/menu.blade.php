<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/menu.css')
    <title>Relatório</title>
</head>

<body>
    <header>
        <div class="text-container">
            <h1>ESPELHO DE PONTO</h1>
        </div>
    </header>

    <div class="search-container">
        <div class="search">
            <h2>Buscar pelo nome</h2>
            <form class="form" id="form-buscar" action="GET">
                <input class="input-search" type="text" id="search" name="search"
                    placeholder="Digite o nome do servidor">
                <button class="button-submit" type="submit">Buscar</button>
            </form>
        </div>
    </div>

    <div id="result-container" class="result-container"></div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="{{ asset('js/menu.js') }}"></script>
</body>

</html>