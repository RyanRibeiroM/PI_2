<?php if (empty($id_caixaDeMensagem)) { ?>
    <div class="col-xxl-9">
        <div class="card h-100 p-0 email-card">
            <div class="card-header border-bottom bg-base py-16 px-24">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-4">
                    <div class="d-flex align-items-center gap-3">
                        <a href="/caixa-de-entrada/" class="reload-button text-secondary-light text-xl d-flex">
                            <iconify-icon icon="tabler:reload" class="icon"></iconify-icon>
                        </a>
                    </div>

                </div>
            </div>
            <div class="card-body p-0">
                <?php if (!empty($caixas)) { ?>
                    <ul class="overflow-x-auto">
                        <?php foreach ($caixas as $caixa) { ?>
                            <li class="email-item px-24 py-16 d-flex gap-4 align-items-center border-bottom cursor-pointer bg-hover-neutral-200 min-w-max-content ">
                                <a href="/caixa-de-entrada/<?= $caixa['id'] ?>/detalhes/" class="text-primary-light fw-medium text-md text-line-1 w-190-px">
                                    <?php if ($caixa['remetente'] == $usuarioLogado['id']) {
                                        echo $caixa['destinatario_nome'];
                                    } else {
                                        echo $caixa['remetente_nome'];
                                    } ?>
                                </a>
                                <a href="/caixa-de-entrada/<?= $caixa['id'] ?>/detalhes"
                                    class="text-primary-light fw-medium mb-0 text-line-1 max-w-740-px"><?= $caixa['ultima_mensagem'] ?></a>
                                <span class="text-primary-light fw-medium min-w-max-content ms-auto"><?= formatarDataHora($caixa['ultima_data_envio']) ?></span>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else {
                    echo '<div class="text-center m-3">a caixa está vazia...</div>';
                } ?>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="col-xxl-9">
        <div class="card h-100 p-0 email-card overflow-x-auto d-block">
            <div class="min-w-450-px d-flex flex-column justify-content-between h-100">
                <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center gap-3 justify-content-between flex-wrap">
                    <div class="d-flex align-items-center gap-2">
                        <a href="/caixa-de-entrada" class="text-secondary-light d-flex me-8"><iconify-icon icon="mingcute:arrow-left-line" class="icon fs-3 line-height-1"></iconify-icon></a>
                        <h6 class="mb-0 text-lg">
                            <?php if ($caixa['remetente'] == $usuarioLogado['id']) {
                                echo $caixa['destinatario_nome'];
                            } else {
                                echo $caixa['remetente_nome'];
                            } ?>
                        </h6>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <?php if (empty($caixa['concluido_por'])) { ?>
                            <button class="text-secondary-light d-flex" data-bs-toggle="modal" data-bs-target="#caixa-concluir-modal"><i class="fa-solid fa-check"></i></button>
                        <?php } ?>
                        <button class="text-secondary-light d-flex" data-bs-toggle="modal" data-bs-target="#caixa-apagar-modal"><i class="fa-solid fa-trash-can"></i></button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?php foreach ($mensagens as $mensagem) { ?>
                        <div class="py-16 px-24 border-bottom">
                            <div class="d-flex align-items-start gap-3">
                                <img src="<?= $mensagem['remetente_imagemPerfil'] ?>" alt="" class="w-40-px h-40-px rounded-pill">
                                <div class="">
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <h6 class="mb-0 text-lg">
                                            <?php if ($mensagem['remetente'] == $usuarioLogado['id']) {
                                                echo 'Você';
                                            } else {
                                                echo $mensagem['remetente_nome'];
                                            } ?>
                                        </h6>
                                        <span class="text-secondary-light text-md">
                                            <?= $mensagem['remetente_email'] ?>
                                        </span>
                                    </div>
                                    <div class="mt-20">
                                        <p class="mb-16 text-primary-light"><?= $mensagem['conteudo'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="card-footer py-16 px-24 bg-base shadow-top">
                    <?php if (empty($caixa['concluido_por'])) { ?>
                        <form method="POST">
                            <div class="d-flex align-items-center justify-content-between">
                                <textarea class="textarea-max-height form-control p-0 border-0 py-8 pe-16 resize-none scroll-sm" oninput="adjustHeight(this)" placeholder="Escreva Uma Mensagem" name="conteudo"></textarea>
                                <div class="d-flex align-items-center gap-4 ms-16">
                                    <button type="submit" class="btn btn-primary text-sm btn-sm px-12 py-12 w-100 radius-8 d-flex align-items-center justify-content-center gap-1 h-44-px" name="enviar_resposta_caixa">
                                        <iconify-icon icon="ion:paper-plane-outline" class="icon text-lg line-height-1"></iconify-icon>
                                        Enviar
                                    </button>
                                </div>
                            </div>
                        </form>
                    <?php } else { ?>
                        <?php if ($caixa['concluido_por'] == $usuarioLogado['id']) {
                            echo '<center><p>Você finalizou essa conversa!</p></center>';
                        } else {
                            if ($caixa['remetente'] == $usuarioLogado['id']) {
                                echo 'Essa conversa foi finalizada por ' . $caixa['destinatario_nome'];
                            } else {
                                echo 'Essa conversa foi finalizada por ' . $caixa['remetente_nome'];
                            }
                        } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>