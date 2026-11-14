// Aguarda o carregamento completo do HTML antes de executar o código.
document.addEventListener("DOMContentLoaded", function () {

    // Busca o elemento responsável por exibir mensagens na página.
    const mensagem = document.getElementById("mensagem");

    // Recupera a mensagem armazenada anteriormente no sessionStorage.
    const texto = sessionStorage.getItem("mensagemPerfil");

    // Verifica se existe uma mensagem armazenada e se o elemento está disponível.
    if (texto && mensagem) {

        // Insere o texto recuperado no elemento de mensagem.
        mensagem.textContent = texto;

        // Adiciona a classe responsável por tornar a mensagem visível.
        mensagem.classList.add("mostrar");

        // Remove a mensagem do sessionStorage para que ela não apareça novamente.
        sessionStorage.removeItem("mensagemPerfil");

        // Aguarda 4 segundos antes de ocultar a mensagem.
        setTimeout(function () {

            // Remove a classe que mantém a mensagem visível.
            mensagem.classList.remove("mostrar");

        }, 4000);
    }

    // Busca o modal utilizado para confirmar a exclusão de usuários.
    const modal = document.getElementById("modalExcluir");

    // Verifica se o modal existe na página.
    if (modal) {

        // Identifica os cliques realizados dentro da área do modal.
        modal.addEventListener("click", function (evento) {

            // Verifica se o clique aconteceu diretamente no fundo do modal,
            // e não em algum elemento que esteja dentro dele.
            if (evento.target === modal) {

                // Fecha o modal.
                fecharModal();
            }
        });
    }

    // Identifica quando alguma tecla é pressionada no teclado.
    document.addEventListener("keydown", function (evento) {

        // Verifica se a tecla pressionada foi Escape.
        if (evento.key === "Escape") {

            // Fecha o modal quando essa tecla for utilizada.
            fecharModal();
        }
    });

    // Busca o formulário responsável pela exclusão de usuários.
    const formulario = document.getElementById("formExcluirPessoa");

    // Verifica se o formulário existe na página.
    if (formulario) {

        // Verifica os dados antes de permitir o envio do formulário.
        formulario.addEventListener("submit", function (evento) {

            // Obtém o identificador do usuário que será excluído.
            const id = document.getElementById("idPessoaExcluir").value;

            // Verifica se o identificador está vazio, não é um número inteiro
            // ou possui um valor menor ou igual a zero.
            if (!id || !Number.isInteger(Number(id)) || Number(id) <= 0) {

                // Impede o envio do formulário caso o identificador seja inválido.
                evento.preventDefault();

                // Exibe um aviso informando que não foi possível identificar
                // o usuário selecionado.
                alert("Não foi possível identificar o usuário selecionado.");
            }
        });
    }
});

// Função responsável por abrir o modal de confirmação de exclusão.
function abrirModal(botao, nome) {

    // Busca os elementos que serão utilizados no modal.
    const modal = document.getElementById("modalExcluir");
    const campoId = document.getElementById("idPessoaExcluir");
    const nomeUsuario = document.getElementById("nomeUsuarioExcluir");

    // Verifica se todos os elementos necessários existem.
    // Caso algum esteja ausente, encerra a função.
    if (!modal || !campoId || !nomeUsuario) {
        return;
    }

    // Obtém o identificador do usuário a partir do atributo data-id do botão
    // e preenche o campo oculto do formulário de exclusão.
    campoId.value = botao.dataset.id;

    // Exibe o nome do usuário que será excluído no modal.
    nomeUsuario.textContent = nome;

    // Adiciona a classe responsável por exibir o modal na página.
    modal.classList.add("mostrar");
}

// Função responsável por fechar o modal de confirmação de exclusão.
function fecharModal() {

    // Busca o modal na página.
    const modal = document.getElementById("modalExcluir");

    // Verifica se o modal existe.
    if (modal) {

        // Remove a classe responsável por exibir o modal.
        modal.classList.remove("mostrar");
    }
}

// Aguarda o carregamento completo do HTML antes de executar
// as funcionalidades de pesquisa de usuários.
document.addEventListener('DOMContentLoaded', function () {

    // Busca o campo de pesquisa e a tabela que contém a lista de usuários.
    const campoPesquisa = document.getElementById('pesquisarPessoa');
    const listaPessoas = document.getElementById('listaPessoas');

    // Verifica se os dois elementos existem na página.
    // Caso contrário, encerra a execução.
    if (!campoPesquisa || !listaPessoas) {
        return;
    }

    // Identifica quando o usuário digita ou apaga alguma informação
    // no campo de pesquisa.
    campoPesquisa.addEventListener('input', function () {

        // Obtém o texto digitado, remove os espaços das extremidades
        // e transforma todas as letras em minúsculas.
        const pesquisa = campoPesquisa.value
            .trim()
            .toLocaleLowerCase('pt-BR');

        // Seleciona todas as linhas da tabela, exceto a linha
        // utilizada para exibir a mensagem de ausência de resultados.
        const linhas = listaPessoas.querySelectorAll('tr:not(.sem-resultado)');

        // Inicializa o contador de usuários encontrados.
        let encontrados = 0;

        // Percorre todas as linhas da tabela para realizar a pesquisa.
        linhas.forEach(function (linha) {

            // Obtém o texto presente na linha e transforma as letras
            // em minúsculas para facilitar a comparação.
            const texto = linha.textContent
                .toLocaleLowerCase('pt-BR');

            // Verifica se o conteúdo da linha corresponde ao texto pesquisado.
            if (texto.includes(pesquisa)) {

                // Exibe a linha quando houver correspondência.
                linha.style.display = '';

                // Aumenta a quantidade de usuários encontrados.
                encontrados++;

            } else {

                // Oculta a linha quando não houver correspondência.
                linha.style.display = 'none';
            }

        });

        // Verifica se já existe uma linha com a mensagem
        // de ausência de resultados na tabela.
        let mensagem = listaPessoas.querySelector('.sem-resultado');

        // Verifica se nenhum usuário foi encontrado na pesquisa.
        if (encontrados === 0) {

            // Cria a mensagem somente se ela ainda não existir.
            if (!mensagem) {

                // Cria uma nova linha na tabela.
                mensagem = document.createElement('tr');

                // Adiciona uma classe para identificar essa linha.
                mensagem.classList.add('sem-resultado');

                // Insere a mensagem dentro de uma célula que ocupa
                // as cinco colunas da tabela.
                mensagem.innerHTML = `
                    <td colspan="5">
                        Nenhum usuário encontrado.
                    </td>
                `;

                // Adiciona a nova linha à tabela.
                listaPessoas.appendChild(mensagem);
            }

        } else if (mensagem) {

            // Remove a mensagem quando algum usuário for encontrado.
            mensagem.remove();

        }

    });

});