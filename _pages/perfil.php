<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Perfil</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                    <i class="fa-solid fa-user"></i>
                    StartUFC
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Perfil</li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col-lg-4">
            <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">

                <div class="pb-24 ms-16 mb-24 me-16">
                    <div class="text-center border border-top-0 border-start-0 border-end-0">
                        <img src="<?= $informacoesUsuario['imagemPerfil'] ?>" alt="" class="border br-white border-width-2-px w-200-px h-200-px rounded-circle object-fit-cover">
                        <h6 class="mb-0 mt-16"><?= $informacoesUsuario['nome'] ?></h6>
                        <span class="text-secondary-light mb-16"><?= $informacoesUsuario['email'] ?></span>
                    </div>
                    <div class="mt-24">
                        <h6 class="text-xl mb-16">Informações Pessoais</h6>
                        <ul>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">Nome Completo</span>
                                <span class="w-70 text-secondary-light fw-medium">: <?= $informacoesUsuario['nome'] . " " . $informacoesUsuario['sobrenome'] ?></span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Email</span>
                                <span class="w-70 text-secondary-light fw-medium">: <?= $informacoesUsuario['email'] ?></span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Telefone</span>
                                <span class="w-70 text-secondary-light fw-medium">: <?php if ($informacoesUsuario['telefone'] != "") {
                                                                                        echo $informacoesUsuario['telefone'];
                                                                                    } else {
                                                                                        echo 'Não Informado';
                                                                                    } ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-body p-24">
                    <ul class="nav border-gradient-tab nav-pills mb-20 d-inline-flex" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center px-24 active" id="pills-edit-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-edit-profile" type="button" role="tab" aria-controls="pills-edit-profile" aria-selected="true">
                                Editar perfil
                            </button>
                        </li>
                        <?php ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center px-24" id="pills-change-passwork-tab" data-bs-toggle="pill" data-bs-target="#pills-change-passwork" type="button" role="tab" aria-controls="pills-change-passwork" aria-selected="false" tabindex="-1">
                                Trocar Senha
                            </button>
                        </li>
                        <?php ?>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-edit-profile" role="tabpanel" aria-labelledby="pills-edit-profile-tab" tabindex="0">
                            <?php
                            echo $_SESSION['mensagemEditarPerfil'] ?? "";
                            unset($_SESSION['mensagemEditarPerfil']);
                            ?>
                            <form id="formularioEditarPerfil" method="POST" enctype="multipart/form-data">
                                <h6 class="text-md text-primary-light mb-16">Sua imagem</h6>
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
                                            <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">Nome Completo <span class="text-danger-600">*</span></label>
                                            <input type="text" class="form-control radius-8" name="nomeCompleto" id="nome" placeholder="Nome Completo" value="<?= $informacoesUsuario['nome'] . " " . $informacoesUsuario['sobrenome'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-20">
                                            <label for="number" class="form-label fw-semibold text-primary-light text-sm mb-8">Telefone</label>
                                            <input type="tel" class="form-control radius-8" name="telefone" id="telefone" pattern="\(\d{2}\) \d{5}-\d{4}" placeholder="Telefone (XX) XXXX-XXXX" value="<?= $informacoesUsuario['telefone'] ?>">
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                        <button type="submit" name="btn-editarPerfil" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                            Salvar
                                        </button>
                                    </div>
                            </form>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-change-passwork" role="tabpanel" aria-labelledby="pills-change-passwork-tab" tabindex="0">
                        <form method="post">
                            <div class="mb-20">
                                <label for="your-password" class="form-label fw-semibold text-primary-light text-sm mb-8">Nova Senha <span class="text-danger-600">*</span></label>
                                <div class="position-relative">
                                    <input type="password" class="form-control radius-8" id="your-password" name="senha" placeholder="Nova Senha*">
                                    <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#your-password"></span>
                                </div>
                            </div>
                            <div class="mb-20">
                                <label for="confirm-password" class="form-label fw-semibold text-primary-light text-sm mb-8">Confimar Senha <span class="text-danger-600">*</span></label>
                                <div class="position-relative">
                                    <input type="password" class="form-control radius-8" id="confirm-password" name="confirmar-senha" placeholder="Confirmar Senha*">
                                    <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#confirm-password"></span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <button type="submit" name="btn-editarSenha" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                    Salvar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>