<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Mural</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="mural/" class="d-flex align-items-center gap-1 hover-text-primary">
                    <i class="fa-solid fa-plus"></i>
                    Mural
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Cadastro</li>
        </ul>
    </div>

    <div class="card h-100 p-0 radius-12 overflow-hidden">
        <div class="py-16 px-24">
            <?= $mensagem_mural ?? "" ?>
        </div>
        <div class="card-body p-40">
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="mb-20">
                            <label for="titulo" class="form-label fw-semibold text-primary-light text-sm mb-8">Título<span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8" id="titulo" name="titulo" placeholder="Título do poste" value="<?= $_POST['titulo'] ?? "" ?>">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-20">
                            <label for="texto" class="form-label fw-semibold text-primary-light text-sm mb-8">Um pequeno texto do poste <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8" id="texto" name="texto" placeholder="Digite o texto do poste" value="<?= $_POST['texto'] ?? "" ?>">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-20">
                            <label for="country" class="form-label fw-semibold text-primary-light text-sm mb-8">Tipo de poste <span class="text-danger-600">*</span> </label>
                            <select class="form-control radius-8 form-select" name="tipos_mural" id="tipos_mural">
                                <option selected disabled>Selecione o tipo...</option>
                                <option value="unico" <?php if (isset($_POST['tipos_mural']) && $_POST['tipos_mural'] == "unico") echo "selected" ?>>Imagem única (768x455)</option>
                                <option value="carrosel" <?php if (isset($_POST['tipos_mural']) && $_POST['tipos_mural'] == "carrosel") echo "selected" ?>>Carrosel (768x455)</option>
                            </select>
                        </div>
                    </div>
                    <center>
                        <div class="col-md-6">
                            <div class="card h-100 p-0">
                                <div class="card-header border-bottom bg-base py-16 px-24">
                                    <h6 class="text-lg fw-semibold mb-0">Envie as Imagens aqui</h6>
                                </div>
                                <div class="card-body p-24">

                                    <div class="upload-image-wrapper d-flex align-items-center gap-3 flex-wrap">
                                        <div class="uploaded-imgs-container d-flex gap-3 flex-wrap"></div>

                                        <label class="upload-file-multiple h-120-px w-120-px border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50 bg-hover-neutral-200 d-flex align-items-center flex-column justify-content-center gap-1" for="upload-file-multiple">
                                            <iconify-icon icon="solar:camera-outline" class="text-xl text-secondary-light"></iconify-icon>
                                            <span class="fw-semibold text-secondary-light">Enviar</span>
                                            <input id="upload-file-multiple" type="file" hidden multiple>
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </center>

                    <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                        <button type="submit" name="novo_mural" class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8">
                            Criar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>