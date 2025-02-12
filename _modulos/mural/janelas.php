<?php if (empty($sub_pagina)) { ?>
    <div class="modal" id="mural-ativo-modal" tabindex="-1" role="dialog" aria-labelledby="mural-ativo-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <p class="text-white modal-title" id="riskModalLabel">Desativar</p>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Você está prestes a <strong>Desativar</strong> um elemento do mural. Tem certeza?
                </div>
                <form method="post">
                    <input type="hidden" name="id-mural" id="id-mural" class="id-mural">
                    <input type="hidden" name="titulo-mural" id="titulo-mural" class="titulo-mural">
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="btn btn-warning" name="desativar-mural">Desativar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="mural-apagar-modal" tabindex="-1" role="dialog" aria-labelledby="mural-apagar-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <p class="text-white modal-title" id="dangerModalLabel">
                        Apagar
                    </p>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Você está prestes a <strong>Apagar</strong> um elemento do mural. Tem certeza?
                </div>
                <form method="post">
                    <input type="hidden" name="id-mural" id="id-mural" class="id-mural">
                    <input type="hidden" name="titulo-mural" id="titulo-mural" class="titulo-mural">
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" name="apagar-mural" class="btn btn-danger">Apagar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="mural-ativar-modal" tabindex="-1" role="dialog" aria-labelledby="mural-ativar-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <p class="text-white modal-title" id="successModalLabel">Ativar</p>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Você está prestes a <strong>Ativar</strong> um elemento do mural. Tem certeza?
                </div>
                <form method="post">
                    <input type="hidden" name="id-mural" id="id-mural" class="id-mural">
                    <input type="hidden" name="titulo-mural" id="titulo-mural" class="titulo-mural">
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="btn btn-success" name="ativar-mural">Ativar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function pegarInformacoesMural(btn) {
            const id = btn.getAttribute('data-id-mural');
            const titulo = btn.getAttribute('data-titulo-mural');

            document.querySelectorAll('.id-mural').forEach((input) => {
                input.value = id;
            });

            document.querySelectorAll('.titulo-mural').forEach((input) => {
                input.value = titulo;
            });
        }

        document.querySelectorAll('.btn-desativar-mural').forEach(function(btn) {
            btn.addEventListener('click', function() {
                pegarInformacoesMural(this);
            });
        });
        document.querySelectorAll('.btn-apagar-mural').forEach(function(btn) {
            btn.addEventListener('click', function() {
                pegarInformacoesMural(this);
            });
        });
        document.querySelectorAll('.btn-ativar-mural').forEach(function(btn) {
            btn.addEventListener('click', function() {
                pegarInformacoesMural(this);
            });
        });
    </script>
<?php } ?>
<?php if (!empty($sub_pagina) && $sub_pagina === "cadastrar") { ?>
    <div class="modal" id="mural-quantidade-modal" tabindex="-1" role="dialog" aria-labelledby="mural-quantidade-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <p class="text-white modal-title" id="riskModalLabel">Quantidade inválida</p>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    A quantidade de imagens enviadas é <strong>Inválida</strong> para o tipo de mural selecionado.
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">Fechar</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>