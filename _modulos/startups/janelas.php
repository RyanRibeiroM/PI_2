<?php if (empty($sub_pagina)) { ?>
    <div class="modal" id="startup-ativo-modal" tabindex="-1" role="dialog" aria-labelledby="startup-ativo-modal" aria-hidden="true">
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
                    Você está prestes a <strong class="acao"></strong> a startup <strong class="nome_startup"></strong>. Tem certeza?
                </div>
                <form method="post">
                    <input type="hidden" name="id_startup" class="id_startup">
                    <input type="hidden" name="cnpj_startup" class="cnpj_startup">
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="btn btn-warning btn_ativar_desativar" name="desativar_startup">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="startup-apagar-modal" tabindex="-1" role="dialog" aria-labelledby="startup-apagar-modal" aria-hidden="true">
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
                    Você está prestes a <strong>apagar</strong> a startup <strong class="nome_startup"></strong>. Tem certeza?
                </div>
                <form method="post">
                    <input type="hidden" name="id_startup" class="id_startup">
                    <input type="hidden" name="cnpj_startup" class="cnpj_startup">
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="btn btn-danger" name="deletar_startup">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function pegarInformacoes(btn) {
            const nome = btn.getAttribute('data-nome-startup');
            const id = btn.getAttribute('data-id-startup');
            const cnpj = btn.getAttribute('data-cnpj-startup');
            const acao_form = btn.getAttribute('data-acao-form');

            document.querySelectorAll('.nome_startup').forEach(function(p) {
                p.textContent = `${nome}`;
            });

            document.querySelectorAll('.id_startup').forEach(function(input) {
                input.value = id;
            });

            document.querySelectorAll('.cnpj_startup').forEach(function(input) {
                input.value = cnpj;
            });

            document.querySelectorAll('.btn_ativar_desativar').forEach(function(btn) {
                if (acao_form == 'Desativar') {
                    btn.name = 'desativar_startup';
                } else {
                    btn.name = 'ativar_startup';
                }
            });

            document.querySelectorAll('.acao').forEach(function(p) {
                p.textContent = `${acao_form}`;
            });

            document.querySelectorAll('.modal-title').forEach(function(p) {
                p.textContent = `${acao_form}`;
            });
        }

        document.querySelectorAll('.btn_desativar').forEach(function(btn) {
            btn.addEventListener('click', function() {
                pegarInformacoes(this)
            });
        });

        document.querySelectorAll('.btn_deletar').forEach(function(btn) {
            btn.addEventListener('click', function() {
                pegarInformacoes(this)
            });
        });
    </script>
<?php } ?>

<?php if (!empty($sub_pagina) && $sub_pagina == 'minhastartup') { ?>

    <div class="modal" id="membro-excluir-modal" tabindex="-1" role="dialog" aria-labelledby="membro-excluir-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <p class="text-white modal-title" id="dangerModalLabel">
                        Excluir da StartUP
                    </p>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Você está prestes a <strong>excluir</strong> o membro <strong class="nome_membro"> da StartUP</strong>. Tem certeza?
                </div>
                <form method="post">
                    <input type="hidden" name="id_membro" class="id_membro">
                    <input type="hidden" name="email_membro" class="email_membro">
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="btn btn-danger" name="excluir_membro">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function pegarInformacoes(btn) {
            const nome = btn.getAttribute('data-nome-membro');
            const id = btn.getAttribute('data-id-membro');
            const email = btn.getAttribute('data-email-membro');
            const acao_form = btn.getAttribute('data-acao-form');

            document.querySelectorAll('.nome_membro').forEach(function(p) {
                p.textContent = `${nome}`;
            });

            document.querySelectorAll('.id_membro').forEach(function(input) {
                input.value = id;
            });

            document.querySelectorAll('.email_membro').forEach(function(input) {
                input.value = email;
            });

            document.querySelectorAll('.acao').forEach(function(p) {
                p.textContent = `${acao_form}`;
            });

            document.querySelectorAll('.modal-title').forEach(function(p) {
                p.textContent = `${acao_form}`;
            });
        }

        document.querySelectorAll('.btn_excluir').forEach(function(btn) {
            btn.addEventListener('click', function() {
                pegarInformacoes(this)
            });
        });
    </script>
<?php } ?>