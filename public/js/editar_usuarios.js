// Busca o formulário de edição do perfil e identifica quando ele é enviado.
document.getElementById("formularioPerfil").addEventListener("submit", function(evento) {

    // Impede que o formulário seja enviado da maneira padrão.
    evento.preventDefault();

    // Armazena uma mensagem de sucesso no sessionStorage.
    // Essa mensagem poderá ser recuperada depois, ao retornar para a página.
    sessionStorage.setItem(
        "mensagemPerfil",
        "Alterações salvas com sucesso!"
    );

    // Redireciona o usuário para o endereço do link que possui a classe
    // "btn-cancelar", utilizando o próprio formulário como referência.
    window.location.href = this.querySelector(".btn-cancelar").href;
});