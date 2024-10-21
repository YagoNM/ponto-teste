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

                // Verifica se há usuários retornados
                if (response.data.usuario && response.data.usuario.length > 0) {
                    // Itera pelos usuários retornados e exibe na tela
                    response.data.usuario.forEach(function (user) {
                        const resultItem = `
                        <div class="result-item">
                            <h3>${user.nome}</h3>
                            <p>PIS: ${user.pis}</p>
                        </div>
                    `;
                        resultContainer.innerHTML += resultItem;
                    });
                } else {
                    // Caso não haja resultados, exibe uma mensagem
                    resultContainer.innerHTML = '<p>Usuário não encontrado.</p>';
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
