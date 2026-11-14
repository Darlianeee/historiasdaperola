// Confirmação antes de enviar o pedido de exclusão.

// Função responsável por confirmar se o usuário realmente deseja
// excluir o comentário selecionado.
function confirmarExclusaoComentario(formulario) {

    // Exibe uma janela de confirmação perguntando se o usuário deseja
    // continuar com a exclusão do comentário.
    const confirmado = window.confirm(
        'Tem certeza de que deseja excluir este comentário? ' +
        'Essa ação não poderá ser desfeita.'
    );

    // Verifica se o usuário cancelou a exclusão.
    if (!confirmado) {

        // Retorna false para impedir o envio do formulário.
        return false;
    }

    // Retorna true quando o usuário confirma a exclusão,
    // permitindo que o formulário seja enviado.
    return true;
}