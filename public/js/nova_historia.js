const botoes = document.querySelectorAll(".idiomas button");

const titulo = document.getElementById("titulo");
const legenda = document.getElementById("legenda");
const texto = document.getElementById("texto");

const labelTitulo = document.getElementById("labelTitulo");
const labelLegenda = document.getElementById("labelLegenda");
const labelTexto = document.getElementById("labelTexto");

let idioma = "pt";

let dados = {
    pt: {
        titulo: "",
        legenda: "",
        texto: ""
    },

    es: {
        titulo: "",
        legenda: "",
        texto: ""
    },

    wari: {
        titulo: "",
        legenda: "",
        texto: ""
    }
};


botoes.forEach(botao => {

    botao.addEventListener("click", function () {

        // SALVA os dados do idioma atual
        dados[idioma].titulo = titulo.value;
        dados[idioma].legenda = legenda.value;
        dados[idioma].texto = texto.value;


        // TROCA o idioma
        idioma = this.dataset.idioma;


        // MOSTRA os dados do novo idioma
        titulo.value = dados[idioma].titulo;
        legenda.value = dados[idioma].legenda;
        texto.value = dados[idioma].texto;


        // ==========================
        // PORTUGUÊS
        // ==========================

        if (idioma == "pt") {

            labelTitulo.textContent = "Título (Português)";
            labelLegenda.textContent = "Legenda da imagem (Português)";
            labelTexto.textContent = "Texto (Português)";

            titulo.placeholder = "Digite o título em português...";
            legenda.placeholder = "Digite a legenda da imagem em português...";
            texto.placeholder = "Digite o texto em português...";
        }


        // ==========================
        // ESPANHOL
        // ==========================

        if (idioma == "es") {

            labelTitulo.textContent = "Título (Espanhol)";
            labelLegenda.textContent = "Legenda da imagem (Espanhol)";
            labelTexto.textContent = "Texto (Espanhol)";

            titulo.placeholder = "Digite o título em espanhol...";
            legenda.placeholder = "Digite a legenda da imagem em espanhol...";
            texto.placeholder = "Digite o texto em espanhol...";
        }


        // ==========================
        // WARI' ORO NAO
        // ==========================

        if (idioma == "wari") {

            labelTitulo.textContent = "Título (Wari' Oro Nao)";
            labelLegenda.textContent = "Legenda da imagem (Wari' Oro Nao)";
            labelTexto.textContent = "Texto (Wari' Oro Nao)";

            titulo.placeholder = "Digite o título em Wari' Oro Nao...";
            legenda.placeholder = "Digite a legenda da imagem em Wari' Oro Nao...";
            texto.placeholder = "Digite o texto em Wari' Oro Nao...";
        }


        // BOTÃO ATIVO
        botoes.forEach(b => b.classList.remove("ativo"));

        this.classList.add("ativo");

    });

});