<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <div class="d-flex align-items-center gap-4">
            <h6 class="fw-semibold mb-0">Minha StartUP</h6>
            <?php if ($usuarioLogado['nivel'] === 1 || $usuarioLogado['nivel'] === 4) { ?>
                <a href="startups/minha-startup/falar-com-responsavel" class="btn btn-primary-600 radius-8 px-20 py-11"> + Falar com Responsável</a>
            <?php } ?>
        </div>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                    <i class="fa-solid fa-rocket"></i>
                    StartUFC
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Minha StartUP</li>
        </ul>
    </div>
    <div class="col-xxl-12">
        <div class="p-24">
            <?= $mensagem_editar_startup ?? "" ?>
        </div>
        <div class="card p-0 overflow-hidden position-relative radius-12 h-100">
            <div class="card-header py-16 px-24 bg-base border border-end-0 border-start-0 border-top-0">
                <h6 class="text-lg mb-0">Informações</h6>
            </div>
            <div class="card-body p-24 pt-10">
                <ul class="nav button-tab nav-pills mb-16" id="pills-tab-four" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex align-items-center gap-2 fw-semibold text-primary-light radius-4 px-16 py-10 active" id="pills-button-icon-home-tab" data-bs-toggle="pill" data-bs-target="#pills-button-icon-home" type="button" role="tab" aria-controls="pills-button-icon-home" aria-selected="true">
                            <iconify-icon icon="solar:home-smile-angle-outline" class="text-xl"></iconify-icon>
                            <span class="line-height-1">Pagina Inicial</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex align-items-center gap-2 fw-semibold text-primary-light radius-4 px-16 py-10" id="pills-button-icon-details-tab" data-bs-toggle="pill" data-bs-target="#pills-button-icon-details" type="button" role="tab" aria-controls="pills-button-icon-details" aria-selected="false">
                            <iconify-icon icon="hugeicons:folder-details" class="text-xl"></iconify-icon>
                            <span class="line-height-1">Detalhes</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex align-items-center gap-2 fw-semibold text-primary-light radius-4 px-16 py-10" id="pills-button-icon-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-button-icon-profile" type="button" role="tab" aria-controls="pills-button-icon-profile" aria-selected="false">
                            <iconify-icon icon="iconamoon:profile" class="text-xl"></iconify-icon>
                            <span class="line-height-1">Membros</span>
                        </button>
                    </li>
                    <?php if ($usuarioLogado['nivel'] === 2 || $usuarioLogado['nivel'] === 3) { ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center gap-2 fw-semibold text-primary-light radius-4 px-16 py-10" id="pills-button-icon-settings-tab" data-bs-toggle="pill" data-bs-target="#pills-button-icon-settings" type="button" role="tab" aria-controls="pills-button-icon-settings" aria-selected="false">
                                <iconify-icon icon="uil:setting" class="text-xl"></iconify-icon>
                                <span class="line-height-1">Editar Informações</span>
                            </button>
                        </li>
                    <?php } ?>
                </ul>
                <?php foreach ($dados as $dado) { ?>
                    <div class="tab-content" id="pills-tab-fourContent">
                        <div class="tab-pane fade show active" id="pills-button-icon-home" role="tabpanel" aria-labelledby="pills-button-icon-home-tab" tabindex="0">
                            <div class="d-flex align-items-center gap-3">
                                <div class="flex-shrink-0">
                                    <img src="<?= $dado["imagem"] ?>" class="w-90-px h-90-px rounded-circle" alt="">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="text-lg mb-8 fw-bold">Descrição</h6>
                                    <p class="text-secondary-light mb-16"><?= $dado["descricao"] ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-button-icon-details" role="tabpanel" aria-labelledby="pills-button-icon-details-tab" tabindex="0">
                            <div class="d-flex align-items-center gap-3">
                                <div class="flex-shrink-0">
                                    <img src="<?= $dado["imagem"] ?>" class="w-90-px h-90-px me-12 rounded-circle" alt="">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="text-lg mb-8 fw-bold">Detalhes da StartUP</h6>
                                    <ul>
                                        <li class="d-flex align-items-center gap-1 mb-4">
                                            <span class="w-21 text-md fw-semibold text-primary-light">Nome da StartUP:</span>
                                            <span class="w-21 text-secondary-light fw-medium"><?= $dado["nome"] ?></span>
                                        </li>
                                        <li class="d-flex align-items-center gap-1 mb-4">
                                            <span class="w-21 text-md fw-semibold text-primary-light">CNPJ:</span>
                                            <span class="w-21 text-secondary-light fw-medium"><?= $dado["cnpj"] ?></span>
                                        </li>
                                        <li class="d-flex align-items-center gap-1 mb-4">
                                            <span class="w-21 text-md fw-semibold text-primary-light">Membros:</span>
                                            <span class="w-21 text-secondary-light fw-medium"><?= $dado["membros"] ?></span>
                                        </li>
                                        <li class="d-flex align-items-center gap-1 mb-4">
                                            <span class="w-21 text-md fw-semibold text-primary-light">Responsável:</span>
                                            <span class="w-21 text-secondary-light fw-medium"><?= $dado["responsavel"] ?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-button-icon-profile" role="tabpanel" aria-labelledby="pills-button-icon-profile-tab" tabindex="0">
                            <div class="d-flex align-items-center gap-0">
                                <div class="flex-shrink-0">
                                    <img src="<?= $dado["imagem"] ?>" class="w-90-px h-90-px me-12 rounded-circle" alt="">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="text-lg mb-8 fw-bold mx-5">Membros</h6>
                                    <div class="card-body p-12">
                                        <div class="table-responsive scroll-sm">
                                            <table class="table bordered-table sm-table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">
                                                            <div class="d-flex align-items-center gap-10">
                                                                ID
                                                            </div>
                                                        </th>
                                                        <th scope="col">Nome</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col" class="text-center">Cargo</th>
                                                        <th scope="col" class="text-center">Status</th>
                                                        <?php if ($usuarioLogado['nivel'] === 2 || $usuarioLogado['nivel'] === 3) { ?>
                                                            <th scope="col" class="text-center">Ações</th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($listam as $membro) { ?>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center gap-10">
                                                                    <?= $membro["id"] ?>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-grow-1">
                                                                        <span class="text-md mb-0 fw-normal text-secondary-light"><?= $membro["nome"] ?></span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td><span class="text-md mb-0 fw-normal text-secondary-light"><?= $membro["email"] ?></span></td>
                                                            <td class="text-center">
                                                                <?php if ($membro['nivel'] == 1) { ?>
                                                                    <span class="cargo bg-info-focus text-info-600 border border-info-main px-24 py-4 radius-4 fw-medium text-sm">Membro</span>
                                                                <?php } ?>
                                                                <?php if ($membro['nivel'] == 2) { ?>
                                                                    <span class="cargo bg-warning-200 text-warning-600 border border-warning-400 px-24 py-4 radius-4 fw-medium text-sm">Responsável</span>
                                                                <?php } ?>
                                                                <?php if ($membro['nivel'] == 3) { ?>
                                                                    <span class="cargo bg-danger-200 text-danger-600 border border-danger-400 px-24 py-4 radius-4 fw-medium text-sm">Administrador</span>
                                                                <?php } ?>
                                                                <?php if ($membro['nivel'] == 4) { ?>
                                                                    <span class="cargo bg-success-200 text-success-600 border border-success-400 px-24 py-4 radius-4 fw-medium text-sm">Bolsista StartUFC</span>
                                                                <?php } ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php if ($membro['ativo'] == 1) { ?>
                                                                    <span class="status bg-success-focus text-success-600 border border-success-main px-24 py-4 radius-4 fw-medium text-sm">Ativo</span>
                                                                <?php } ?>
                                                                <?php if ($membro['ativo'] == 2) { ?>
                                                                    <span class="status bg-neutral-200 text-neutral-600 border border-neutral-400 px-24 py-4 radius-4 fw-medium text-sm">Inativo</span>
                                                                <?php } ?>
                                                                <?php if ($membro['ativo'] == 3) { ?>
                                                                    <span class="status bg-danger-200 text-danger-600 border border-danger-400 px-24 py-4 radius-4 fw-medium text-sm">Deletado</span>
                                                                <?php } ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php if (in_array($usuarioLogado['nivel'], [2, 3]) && !in_array($membro['nivel'], [2, 3])) { ?>
                                                                    <div class="d-flex align-items-center gap-10 justify-content-center">
                                                                        <button type="button" data-bs-toggle="modal"
                                                                            data-id-membro="<?= $membro['id'] ?>"
                                                                            data-nome-membro="<?= $membro['nome'] . " " . $membro['sobrenome'] ?>"
                                                                            data-email-membro="<?= $membro['email'] ?>"
                                                                            data-acao-form='Excluir'
                                                                            data-bs-target="#membro-excluir-modal"
                                                                            class="btn_excluir bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                                            <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                                                        </button>
                                                                    </div>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($usuarioLogado['nivel'] === 2 || $usuarioLogado['nivel'] === 3) { ?>
                            <div class="tab-pane fade" id="pills-button-icon-settings" role="tabpanel" aria-labelledby="pills-button-icon-settings-tab" tabindex="0">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="flex-grow-1">
                                        <div class="tab-pane fade show active" id="pills-edit-profile" role="tabpanel" aria-labelledby="pills-edit-profile-tab" tabindex="0">
                                            <?php
                                            echo $_SESSION['mensagemEditarStartup'] ?? "";
                                            unset($_SESSION['mensagemEditarStartup']);
                                            ?>
                                            <form id="formularioEditarStartup" method="POST" enctype="multipart/form-data">
                                                <h6 class="text-md text-primary-light mb-1">Imagem da StartUP</h6>
                                                <!-- Upload Image Start -->
                                                <div class="mb-24 mt-16">
                                                    <div class="avatar-upload">
                                                        <div class="avatar-edit position-absolute bottom-0 end-0 me-24 mt-16 z-1 cursor-pointer">
                                                            <input type='file' name="imagem" id="imageUpload" hidden>
                                                            <label for="imageUpload" class="w-32-px h-32-px d-flex justify-content-center align-items-center bg-primary-50 text-primary-600 border border-primary-600 bg-hover-primary-100 text-lg rounded-circle">
                                                                <iconify-icon icon="solar:camera-outline" class="icon"></iconify-icon>
                                                            </label>
                                                        </div>
                                                        <div class="avatar-preview">
                                                            <div id="imagePreview">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Upload Image End -->
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="mb-20">
                                                            <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">Nome da StartUP <span class="text-danger-600">*</span></label>
                                                            <input type="text" class="form-control radius-8" name="nomeStartup" id="nomeS" placeholder="Nome StartUP" value="<?= $dado["nome"] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="mb-20">
                                                            <label for="cnpj" class="form-label fw-semibold text-primary-light text-sm mb-8">CNPJ</label>
                                                            <input type="text" class="form-control radius-8" name="cnpj" id="cnpj" placeholder="CNPJ XX.XXX.XXX/0001-XX" value="<?= $dado["cnpj"] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="mb-20">
                                                            <label for="desc" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                                Descrição <span class="text-danger-600">*</span>
                                                            </label>
                                                            <textarea class="form-control radius-8" name="descStartup" id="descS" placeholder="Digite a descrição..."><?= htmlspecialchars($dado["descricao"] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                                                        </div>

                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                                        <button type="submit" name="btn-editarStartup" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                                            Salvar
                                                        </button>
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>