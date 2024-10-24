document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-buscar');
    const resultContainer = document.getElementById('result-container');

    // Função para obter o dia da semana a partir de uma data
    function getDayOfWeek(dateStr) {
        const diasSemana = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
        const partesData = dateStr.split('/'); // Supondo que o formato seja "dd/mm"
        const data = new Date(`${partesData[1]}/${partesData[0]}/${new Date().getFullYear()}`); // Converte para "mm/dd/aaaa"
        const diaSemana = data.getDay(); // Obtém o índice do dia da semana
        return diasSemana[diaSemana];
    }

    // Função para formatar a data com zero à esquerda
    function formatDateWithLeadingZero(dateStr) {
        const partesData = dateStr.split('/');
        const dia = partesData[0].padStart(2, '0'); // Garante que o dia tenha 2 dígitos
        const mes = partesData[1].padStart(2, '0'); // Garante que o mês tenha 2 dígitos
        return `${dia}/${mes}`; // Retorna a data formatada
    }

    // Função para adicionar dias de sábado e domingo na tabela
    function adicionarSabadoEDomingo(dias) {
        const diasOrdenados = [];

        dias.forEach(function (dia, index) {
            const partesData = dia.split('/');
            const dataAtual = new Date(`${partesData[1]}/${partesData[0]}/${new Date().getFullYear()}`);
            const diaSemana = getDayOfWeek(dia);

            // Se for sexta-feira, adiciona sábado e domingo
            if (diaSemana === 'Sexta') {
                diasOrdenados.push(dia); // Adiciona o dia atual (sexta-feira)

                // Calcula a data de sábado
                const dataSabado = new Date(dataAtual);
                dataSabado.setDate(dataAtual.getDate() + 1); // Sábado é o dia seguinte à sexta-feira
                const diaSabado = dataSabado.getDate().toString().padStart(2, '0');
                const mesSabado = (dataSabado.getMonth() + 1).toString().padStart(2, '0');
                diasOrdenados.push(`${diaSabado}/${mesSabado}`); // Adiciona sábado

                // Calcula a data de domingo
                const dataDomingo = new Date(dataAtual);
                dataDomingo.setDate(dataAtual.getDate() + 2); // Domingo é dois dias após a sexta-feira
                const diaDomingo = dataDomingo.getDate().toString().padStart(2, '0');
                const mesDomingo = (dataDomingo.getMonth() + 1).toString().padStart(2, '0');
                diasOrdenados.push(`${diaDomingo}/${mesDomingo}`); // Adiciona domingo
            } else {
                diasOrdenados.push(dia); // Adiciona o dia normal
            }
        });

        return diasOrdenados;
    }

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

                    // Obter os dias (chaves) dos pontos e adicionar Sábado e Domingo se necessário
                    const dias = Object.keys(pontos);
                    const diasComSabadoDomingo = adicionarSabadoEDomingo(dias);

                    // Criar a estrutura da tabela
                    let tabela = `
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Dia</th>
                                <th>Horário</th>
                                <th>1ª Marc.</th>
                                <th>2ª Marc.</th>
                                <th>3ª Marc.</th>
                                <th>4ª Marc.</th>
                                <th>5ª Marc.</th>
                                <th>6ª Marc.</th>
                            </tr>
                        </thead>
                    <tbody>
                `;

                    // Iterar sobre os pontos e preencher a tabela
                    diasComSabadoDomingo.forEach(function (dia) {
                        const diaSemana = getDayOfWeek(dia);

                        if (diaSemana === 'Sábado' || diaSemana === 'Domingo') {
                            tabela += `
                            <tr>
                                <td>${dia} - ${diaSemana}</td>
                                <td colspan="7">Sem registros</td>
                            </tr>
                        `;
                        } else {
                            const registros = pontos[dia] || []; // Verifica se há registros
                            let horarios = [];

                            registros.forEach(function (registro) {
                                const horarioFormatado = `${registro.hora}:${registro.minutos.toString().padStart(2, '0')}`;
                                horarios.push(horarioFormatado);
                            });

                            // Formatar a data com zero à esquerda
                            const diaFormatado = formatDateWithLeadingZero(dia);

                            // Preenche as colunas do dia
                            tabela += `
                            <tr>
                                <td>${diaFormatado} - ${diaSemana}</td>
                                <td>${registros.length}</td>
                                <td>${horarios[0] || ''}</td>
                                <td>${horarios[1] || ''}</td>
                                <td>${horarios[2] || ''}</td>
                                <td>${horarios[3] || ''}</td>
                                <td>${horarios[4] || ''}</td>
                                <td>${horarios[5] || ''}</td>
                            </tr>
                        `;
                        }
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
