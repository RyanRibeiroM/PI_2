<?php if (empty($id_aviso)) { ?>
    <div class="col-xxl-9">
        <div class="card h-100 p-0 email-card">
            <div class="card-header border-bottom bg-base py-16 px-24">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-4">
                    <div class="d-flex align-items-center gap-3">
                        <button type="button" class="delete-button d-none text-secondary-light text-xl d-flex">
                            <iconify-icon icon="material-symbols:delete-outline" class="icon line-height-1"></iconify-icon>
                        </button>
                        <a href="/caixa-de-entrada/" class="reload-button text-secondary-light text-xl d-flex">
                            <iconify-icon icon="tabler:reload" class="icon"></iconify-icon>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <?php if (!empty($avisos)) { ?>
                    <ul class="overflow-x-auto">
                        <?php foreach ($avisos as $aviso) { ?>
                            <li class="email-item px-24 py-16 d-flex gap-4 align-items-center border-bottom cursor-pointer bg-hover-neutral-200 min-w-max-content ">
                                <a href="/caixa-de-entrada/avisos/<?= $aviso['id'] ?>/detalhes" class="text-primary-light fw-medium text-md text-line-1 w-190-px"><?= $aviso['remetente_nome']; ?></a>
                                <a href="/caixa-de-entrada/avisos/<?= $aviso['id'] ?>/detalhes"
                                    class="text-primary-light fw-medium mb-0 text-line-1 max-w-740-px"><?= $aviso['assunto'] ?></a>
                                <span class="text-primary-light fw-medium min-w-max-content ms-auto"><?= formatarDataHora($aviso['data_envio']) ?></span>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else {
                    echo '<div class="text-center m-3">Não exite avisos...</div>';
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
                        <a href="/caixa-de-entrada/avisos" class="text-secondary-light d-flex me-8"><iconify-icon icon="mingcute:arrow-left-line" class="icon fs-3 line-height-1"></iconify-icon></a>
                        <h6 class="mb-0 text-lg"><?= $aviso['remetente_nome'] ?></h6>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <button class="text-secondary-light d-flex" data-bs-toggle="modal" data-bs-target="#aviso-apagar-modal"><i class="fa-solid fa-trash-can"></i></button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="py-16 px-24">
                        <div class="d-flex align-items-start gap-3">
                            <img src="<?= $aviso['remetente_imagemPerfil'] ?>" alt="" class="w-120-px h-120-px rounded-circle object-fit-cover">
                            <div class="w-100">
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <h6 class="mb-0 text-lg">
                                        <?= $aviso['assunto'] ?>
                                    </h6>
                                </div>
                                <div class="mt-20">
                                    <p class="mb-16 text-primary-light"><?= $aviso['conteudo'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>