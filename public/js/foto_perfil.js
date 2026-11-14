// Busca o campo responsável por selecionar a foto do perfil
// e o elemento que exibirá a pré-visualização da imagem.
const fotoPerfil = document.getElementById('fotoPerfil');
const previewFoto = document.getElementById('previewFoto');

// Identifica quando o usuário seleciona uma imagem no campo de arquivo.
fotoPerfil.addEventListener('change', function () {

    // Obtém o primeiro arquivo selecionado pelo usuário.
    const arquivo = this.files[0];

    // Verifica se algum arquivo foi selecionado.
    if (arquivo) {

        // Cria um leitor para acessar o conteúdo do arquivo selecionado.
        const leitor = new FileReader();

        // Executa esta função quando a leitura do arquivo for concluída.
        leitor.onload = function (e) {

            // Atualiza o endereço da imagem para exibir a foto selecionada
            // na área de pré-visualização.
            previewFoto.src = e.target.result;

        };

        // Lê o arquivo e transforma seu conteúdo em uma URL de dados,
        // permitindo que a imagem seja exibida no navegador.
        leitor.readAsDataURL(arquivo);

    }

});