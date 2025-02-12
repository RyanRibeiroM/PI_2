<?php if (!empty($id_caixaDeMensagem)) { ?>
    <div class="modal" id="caixa-apagar-modal" tabindex="-1" role="dialog" aria-labelledby="caixa-apagar-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <p class="text-white modal-title" id="riskModalLabel">Apagar</p>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Você está prestes a <strong>Apagar</strong> esta conversar. Tem certeza?
                </div>
                <form method="post">
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="btn btn-warning" name="apagar-caixa">Apagar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="caixa-concluir-modal" tabindex="-1" role="dialog" aria-labelledby="caixa-concluir-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <p class="text-white modal-title" id="successModalLabel">Concluir</p>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Você está prestes a <strong>concluir</strong> esta conversa. Ao concluir, não será mais possível enviar mensagens ou receber. Tem certeza?
                </div>
                <form method="post">
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="btn btn-success" name="concluir-caixa">Concluir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php }
if (!empty($id_aviso)) {
?>
    <div class="modal" id="aviso-apagar-modal" tabindex="-1" role="dialog" aria-labelledby="aviso-apagar-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <p class="text-white modal-title" id="riskModalLabel">Apagar</p>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Você está prestes a <strong>Apagar</strong> este aviso. Ao apagar, você não poderá mais vê-lo. Tem certeza?
                </div>
                <form method="post">
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="btn btn-warning" name="apagar-aviso">Apagar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>