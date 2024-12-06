<div class="dashboard-main-body">

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Cadastro</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                    <i class="fa-solid fa-plus"></i>
                    StartUFC
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Cadastro</li>
        </ul>
    </div>
    <div class="card h-100 p-0 radius-12">
        <div class="p-24">
            <?= $mensagem_cadastro_startup ?? "" ?>
        </div>
        <h6 class="fw-semibold mb-0 text-center">Cadastre uma nova StartUP!</h6>
        <div class="card-body p-24">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-xl-8 col-lg-10">
                    <div class="card border">
                        <div class="card-body">
                            <div class="row gy-6">
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="avatar-upload">
                                        <label class="form-label mx-3">Logo da StartUp</label>
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
                                <div class="col-12">
                                    <label class="form-label">Nome</label>
                                    <input type="text" name="nome-strt" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">CNPJ</label>
                                    <input type="text" name="cnpj-strt" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Nome ou Email do Responsavel</label>
                                    <input type="text" name="responsavel-strt" class="form-control">
                                </div>

                                <div class="col-lg-12">
                                    <label class="form-label">Descrição</label>
                                    <textarea name="#0" class="form-control mb-3" rows="4" cols="50" placeholder="Digite a descrição da startup..."></textarea>
                                </div>
                                <div
                                    class="d-flex align-items-center justify-content-center gap-3 mt-4">
                                    <button
                                        type="submit"
                                        class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8"
                                        name="cadastrarUsuario">
                                        Cadastrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>