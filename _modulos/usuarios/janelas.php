<div class="modal" id="usuario-ativo-modal" tabindex="-1" role="dialog" aria-labelledby="usuario-ativo-modal" aria-hidden="true">
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
                Você está prestes a <strong class="acao"></strong> o usuário <strong class="nome_usuario"></strong>. Tem certeza?
            </div>
            <form method="post">
                <input type="hidden" name="id_usuario" class="id_usuario">
                <input type="hidden" name="email_usuario" class="email_usuario">
                <div class="modal-footer d-flex justify-content-center">
                    <button type="submit" class="btn btn-warning btn_ativar_desativar" name="desativar_usuario">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="usuario-apagar-modal" tabindex="-1" role="dialog" aria-labelledby="usuario-apagar-modal" aria-hidden="true">
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
                Você está prestes a <strong>apagar</strong> o usuário <strong class="nome_usuario"></strong>. Tem certeza?
            </div>
            <form method="post">
                <input type="hidden" name="id_usuario" class="id_usuario">
                <input type="hidden" name="email_usuario" class="email_usuario">
                <div class="modal-footer d-flex justify-content-center">
                    <button type="submit" class="btn btn-danger" name="deletar_usuario">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function pegarInformacoes(btn) {
        const nome = btn.getAttribute('data-nome-usuario');
        const id = btn.getAttribute('data-id-usuario');
        const email = btn.getAttribute('data-email-usuario');
        const acao_form = btn.getAttribute('data-acao-form');

        document.querySelectorAll('.nome_usuario').forEach(function(p) {
            p.textContent = `${nome}`;
        });

        document.querySelectorAll('.id_usuario').forEach(function(input) {
            input.value = id;
        });

        document.querySelectorAll('.email_usuario').forEach(function(input) {
            input.value = email;
        });

        document.querySelectorAll('.btn_ativar_desativar').forEach(function(btn) {
            if (acao_form == 'Desativar') {
                btn.name = 'desativar_usuario';
            } else {
                btn.name = 'ativar_usuario';
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