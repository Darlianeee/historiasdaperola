<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Responder Comentário</title>

    <link rel="stylesheet" href="<?=URL?>/public/css/responder_comentario.css">
</head>

<body>

    <?php include '../App/Views/administrador/menu_adm.php'; ?>

    <main class="content">

        <!-- TÍTULO -->
        <div class="page-title">

            <div class="title-line"></div>

            <div>
                <h1>Responder comentário</h1>

                <p>
                    Responda ao comentário enviado pelo usuário.
                </p>
            </div>

        </div>


        <!-- CARD ÚNICO -->
        <section class="reply-card">

            <!-- USUÁRIO + HISTÓRIA -->
            <div class="top-information">

                <div class="info-section">
                    <span class="label">Usuário</span>

                    <span class="value">
                        Nome 
                    </span>
                </div>


                <div class="info-section">
                    <span class="label">História</span>

                    <span class="value">
                        Nome 
                    </span>
                </div>

            </div>


            <!-- COMENTÁRIO -->
            <div class="info-section comment-section">

                <span class="label">Comentário</span>

                <div class="comment-box">
                        xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                    <br>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                    <br>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                </div>

            </div>


            <!-- DATA + HORA -->
            <div class="comment-date">
                dd/mm/aaaa às hh:mm:ss
            </div>


            <!-- RESPOSTA -->
            <div class="response-section">

                <label for="resposta">
                    Sua resposta
                </label>

                <textarea
                    id="resposta"
                    name="resposta"
                    placeholder="Digite sua resposta..."
                    required></textarea>

            </div>


            <!-- BOTÕES -->
            <div class="form-buttons">

                <a
                    href="<?=URL?>/administrador/comentarios_adm"
                    class="cancel-button">
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="reply-button">
                    Enviar
                </button>

            </div>

        </section>

    </main>
    
<?php include '../App/Views/administrador/footer_adm.php'; ?>

</body>

</html>