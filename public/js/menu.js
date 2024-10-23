document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-buscar');
    const resultContainer = document.getElementById('result-container');

    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Impede o envio normal do formulário

        // Pega o valor digitado no campo de busca
        const searchQuery = document.getElementById('search').value;

        // Faz a requisição HTTP usando Axios
        axios.get('/get-servidor', {
            params: {
                search: searchQuery
            }
        })
            .then(function (response) {
                // Limpa os resultados anteriores
                resultContainer.innerHTML = '';
                resultContainer.style.display = 'block';

                if (response.data.servidor && response.data.pontos) {
                    const servidor = response.data.servidor;
                    const pontos = response.data.pontos;

                    // Exibir os detalhes do servidor
                    const servidorInfo = `
                    <div class="servidor-info">
                        <h3>${servidor.nome}</h3>
                        <p>PIS: ${servidor.pis}</p>
                    </div>
                `;
                    resultContainer.innerHTML += servidorInfo;

                    // Criar a estrutura da tabela
                    let tabela = `
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Dia</th>
                                <th>Horário</th>
                                <th>1ª</th>
                                <th>2ª</th>
                                <th>3ª</th>
                                <th>4ª</th>
                                <th>5ª</th>
                                <th>6ª</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                    // Iterar sobre os pontos e preencher a tabela
                    Object.keys(pontos).forEach(function (dia) {
                        const registros = pontos[dia]; // Lista de registros de um dia
                        let horarios = [];

                        registros.forEach(function (registro) {
                            const horarioFormatado = `${registro.hora}:${registro.minutos.toString().padStart(2, '0')} e`;
                            horarios.push(horarioFormatado);
                        });

                        // Preenche as colunas do dia
                        tabela += `
                        <tr>
                            <td>${dia}</td>
                            <td>${registros.length}</td>
                            <td>${horarios[0] || ''}</td>
                            <td>${horarios[1] || ''}</td>
                            <td>${horarios[2] || ''}</td>
                            <td>${horarios[3] || ''}</td>
                            <td>${horarios[4] || ''}</td>
                            <td>${horarios[5] || ''}</td>
                        </tr>
                    `;
                    });

                    // Fechar a tabela
                    tabela += `
                        </tbody>
                    </table>
                `;

                    // Exibir a tabela
                    resultContainer.innerHTML += tabela;
                } else {
                    // Caso não haja resultados, exibe uma mensagem
                    resultContainer.innerHTML = '<p>Usuário ou pontos não encontrados.</p>';
                }
            })
            .catch(function (error) {
                // Exibe uma mensagem de erro
                if (error.response) {
                    resultContainer.innerHTML = `<p>${error.response.data.error}</p>`;
                    resultContainer.style.display = 'block';
                } else {
                    resultContainer.innerHTML = '<p>Ocorreu um erro ao buscar o servidor.</p>';
                }
            });

    });
});
