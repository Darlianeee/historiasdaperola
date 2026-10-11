
(function () {
    'use strict';

    var lista = document.getElementById('itens-comentarios');
    if (!lista) { return; }

    var dialogo   = document.getElementById('dialogo-excluir');
    var modelo    = document.getElementById('modelo-comentario');
    var aviso     = document.getElementById('aviso-acao');
    var total     = document.getElementById('total-comentarios');
    var infoOculto = document.getElementById('info-ocultos');
    var semCom    = document.getElementById('sem-comentarios');

    var alvoExclusao = null;


    /* ---------- apoio ---------- */

    function anunciar(mensagem) {
        if (!aviso) { return; }
        aviso.textContent = '';
        window.setTimeout(function () { aviso.textContent = mensagem; }, 50);
    }

    function doisDigitos(n) {
        return (n < 10 ? '0' : '') + n;
    }

    function dataDeHoje() {
        var d = new Date();
        return doisDigitos(d.getDate()) + '/' + doisDigitos(d.getMonth() + 1) + '/' + d.getFullYear();
    }

    function atualizarContadores() {
        var itens   = lista.querySelectorAll('.comentario-item').length;
        var ocultos = lista.querySelectorAll('.comentario-item.oculto').length;

        total.textContent = itens;
        infoOculto.textContent = '· ' + ocultos + (ocultos === 1 ? ' oculto' : ' ocultos');
        infoOculto.hidden = (ocultos === 0);
        semCom.hidden = (itens > 0);
    }

    function fecharMenus(exceto) {
        var abertos = document.querySelectorAll('.menu-opcoes-comentario.ativo');

        Array.prototype.forEach.call(abertos, function (menu) {
            if (menu === exceto) { return; }

            menu.classList.remove('ativo');

            var botao = menu.parentElement.querySelector('.btn-opcoes');
            if (botao) { botao.setAttribute('aria-expanded', 'false'); }
        });
    }


    /* ---------- ações ---------- */

    function curtir(form) {
        var botao = form.querySelector('.btn-curtir');
        var qtd   = form.querySelector('.qtd-curtidas');

        var curtido = botao.classList.toggle('curtido');
        botao.setAttribute('aria-pressed', curtido ? 'true' : 'false');

        var numero = parseInt(qtd.textContent, 10) || 0;
        qtd.textContent = Math.max(0, numero + (curtido ? 1 : -1));
    }

    function alternarOculto(form) {
        var item   = form.closest('.comentario-item');
        var oculto = item.classList.toggle('oculto');

        item.querySelector('.selo-oculto').hidden  = !oculto;
        item.querySelector('.aviso-oculto').hidden = !oculto;

        // o PHP recebe "ocultar_comentario" ou "mostrar_comentario", conforme o estado atual
        form.querySelector('input[type="hidden"]').name = oculto ? 'mostrar_comentario' : 'ocultar_comentario';
        form.querySelector('.item-menu').textContent    = oculto ? 'Mostrar comentário' : 'Ocultar comentário';

        fecharMenus();
        atualizarContadores();
        anunciar(oculto ? 'Comentário ocultado para os usuários.' : 'Comentário visível para os usuários.');
    }

    function excluir(item) {
        if (!item) { return; }

        item.remove();
        atualizarContadores();
        anunciar('Comentário excluído.');
    }

    function pedirExclusao(form) {
        alvoExclusao = form.closest('.comentario-item');
        fecharMenus();

        if (dialogo && typeof dialogo.showModal === 'function') {
            dialogo.showModal();
        } else if (window.confirm('Deseja realmente excluir este comentário?\nO comentário será apagado permanentemente.')) {
            excluir(alvoExclusao);
            alvoExclusao = null;
        }
    }

    function comentar(form) {
        var campo = form.querySelector('textarea');
        var texto = campo.value.trim();

        if (texto === '') {
            campo.focus();
            return;
        }

        var autor = form.getAttribute('data-autor') || 'Administrador';
        var id    = 'novo-' + Date.now();
        var item  = modelo.content.firstElementChild.cloneNode(true);

        // textContent: o texto digitado nunca é interpretado como HTML
        item.setAttribute('data-id', id);
        item.querySelector('.avatar-comentario').textContent = autor.charAt(0).toUpperCase();
        item.querySelector('.nome-comentario').textContent   = autor;
        item.querySelector('.data-comentario').textContent   = dataDeHoje();
        item.querySelector('.texto-comentario').textContent  = texto;
        item.querySelector('input[name="curtir_comentario"]').value  = id;
        item.querySelector('input[name="excluir_comentario"]').value = id;
        item.querySelector('.btn-opcoes').setAttribute('aria-label', 'Opções do comentário de ' + autor);

        lista.insertBefore(item, lista.firstChild);

        campo.value = '';
        atualizarContadores();
        anunciar('Comentário publicado.');
    }


    /* ---------- eventos (delegados, funcionam também nos comentários novos) ---------- */

    document.addEventListener('submit', function (evento) {
        var form = evento.target;

        if (form.classList.contains('form-curtir')) {
            evento.preventDefault();
            curtir(form);
        } else if (form.classList.contains('form-ocultar')) {
            evento.preventDefault();
            alternarOculto(form);
        } else if (form.classList.contains('form-excluir')) {
            evento.preventDefault();
            pedirExclusao(form);
        } else if (form.classList.contains('secao-comentario')) {
            evento.preventDefault();
            comentar(form);
        }
    });

    document.addEventListener('click', function (evento) {
        var botao = evento.target.closest('.btn-opcoes');

        if (botao) {
            var menu = botao.parentElement.querySelector('.menu-opcoes-comentario');

            fecharMenus(menu);

            var aberto = menu.classList.toggle('ativo');
            botao.setAttribute('aria-expanded', aberto ? 'true' : 'false');
            return;
        }

        if (!evento.target.closest('.menu-opcoes-comentario')) {
            fecharMenus();
        }
    });

    document.addEventListener('keydown', function (evento) {
        if (evento.key !== 'Escape') { return; }

        var aberto = document.querySelector('.menu-opcoes-comentario.ativo');
        if (!aberto) { return; }

        var botao = aberto.parentElement.querySelector('.btn-opcoes');
        fecharMenus();
        if (botao) { botao.focus(); }
    });

    if (dialogo) {
        // fechou o diálogo: se foi pelo botão "Excluir", apaga o comentário escolhido
        dialogo.addEventListener('close', function () {
            if (dialogo.returnValue === 'confirmar') {
                excluir(alvoExclusao);
            }

            dialogo.returnValue = '';
            alvoExclusao = null;
        });

        // clique fora da caixa (no fundo escuro) cancela
        dialogo.addEventListener('click', function (evento) {
            if (evento.target === dialogo) {
                dialogo.close('cancelar');
            }
        });
    }
})();