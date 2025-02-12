<div class="dashboard-main-body">

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <div class="d-flex align-items-center gap-4">
            <h6 class="fw-semibold mb-0">Mural</h6>
            <a href="mural/cadastrar" class="btn btn-primary-600 radius-8 px-20 py-11"> + novo mural</a>
        </div>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="mural/" class="d-flex align-items-center gap-1 hover-text-primary">
                    <i class="fa-solid fa-panorama"></i>
                    Mural
                </a>
            </li>
        </ul>
    </div>
    <?= $mensagem_mural ?? "" ?>
    <div class="row gy-4 mt-2">
        <?php foreach ($murais as $mural) { ?>
            <?php if ($mural['tipo'] == 'unico') { ?>
                <div class="col-sm-6">
                    <div class="card p-0 overflow-hidden position-relative radius-12 ">
                        <div class="row card-header py-16 px-24 bg-base border border-end-0 border-start-0 border-top-0 d-flex justify-content-between align-items-center">
                            <div class="col-10">
                                <h6 class="text-lg mb-0 col-8"><?= $mural['titulo'] ?>
                                    <?php
                                    if ($mural['ativo'] == 2) {
                                        echo '<span class="badge bg-warning-600 text-white fw-medium radius-8 px-8 py-4 ms-2">Desativado</span>';
                                    }
                                    ?>
                                </h6>

                            </div>
                            <div class="d-flex col-2">
                                <?php if ($mural['ativo'] == 2) { ?>
                                    <button type="button" data-bs-toggle="modal"
                                        data-id-mural='<?= $mural['id'] ?>'
                                        data-titulo-mural='<?= $mural['titulo'] ?>'
                                        data-bs-target="#mural-ativar-modal" class="btn-ativar-mural bg-info-focus mx-2 bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                        <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                                    </button>
                                <?php } else { ?>
                                    <button type="button" data-bs-toggle="modal"
                                        data-id-mural='<?= $mural['id'] ?>'
                                        data-titulo-mural='<?= $mural['titulo'] ?>'
                                        data-bs-target="#mural-ativo-modal" class="btn-desativar-mural bg-info-focus mx-2 bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                        <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                                    </button>
                                <?php } ?>
                                <button type="button" data-bs-toggle="modal"
                                    data-id-mural='<?= $mural['id'] ?>'
                                    data-titulo-mural='<?= $mural['titulo'] ?>'
                                    data-bs-target="#mural-apagar-modal" class="btn-apagar-mural bg-danger-focus mx-2 bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                    <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0 default-carousel <?php if ($mural['ativo'] == 2) echo "opacity-75" ?>">
                            <?php foreach ($mural['imagens'] as $imagem) { ?>
                                <div class="gradient-overlay bottom-0 start-0 h-100">
                                    <img src="<?= $imagem ?>" alt="" class="w-100 h-100 object-fit-cover">
                                    <div class="position-absolute start-50 translate-middle-x bottom-0 pb-24 z-1 text-center w-100 max-w-440-px">
                                        <h5 class="card-title text-white text-lg mb-6"><?= $mural['titulo'] ?></h5>
                                        <p class="card-text text-white mx-auto text-sm"><?= $mural['texto'] ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($mural['tipo'] == 'carrosel') { ?>
                <div class="col-sm-6">
                    <div class="card p-0 overflow-hidden position-relative radius-12">
                        <div class="row card-header py-16 px-24 bg-base border border-end-0 border-start-0 border-top-0 d-flex justify-content-between align-items-center">
                            <div class="col-10">
                                <h6 class="text-lg mb-0 col-8"><?= $mural['titulo'] ?>
                                    <?php
                                    if ($mural['ativo'] == 2) {
                                        echo '<span class="badge bg-warning-600 text-white fw-medium radius-8 px-8 py-4 ms-2">Desativado</span>';
                                    }
                                    ?>
                                </h6>
                            </div>
                            <div class="d-flex col-2">
                                <?php if ($mural['ativo'] == 2) { ?>
                                    <button type="button" data-bs-toggle="modal"
                                        data-id-mural='<?= $mural['id'] ?>'
                                        data-titulo-mural='<?= $mural['titulo'] ?>'
                                        data-bs-target="#mural-ativar-modal" class="btn-ativar-mural bg-info-focus mx-2 bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                        <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                                    </button>
                                <?php } else { ?>
                                    <button type="button" data-bs-toggle="modal"
                                        data-id-mural='<?= $mural['id'] ?>'
                                        data-titulo-mural='<?= $mural['titulo'] ?>'
                                        data-bs-target="#mural-ativo-modal" class="btn-desativar-mural bg-info-focus mx-2 bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                        <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                                    </button>
                                <?php } ?>
                                <button type="button" data-bs-toggle="modal"
                                    data-id-mural='<?= $mural['id'] ?>'
                                    data-titulo-mural='<?= $mural['titulo'] ?>'
                                    data-bs-target="#mural-apagar-modal" class="btn-apagar-mural bg-danger-focus mx-2 bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                    <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0 arrow-carousel <?php if ($mural['ativo'] == 2) echo "opacity-75" ?>">
                            <?php foreach ($mural['imagens'] as $imagem) { ?>
                                <div class="gradient-overlay bottom-0 start-0 h-100">
                                    <img src="<?= $imagem ?>" alt="" class="w-100 h-100 object-fit-cover">
                                    <div class="position-absolute start-50 translate-middle-x bottom-0 pb-24 z-1 text-center w-100 max-w-440-px">
                                        <h5 class="card-title text-white text-lg mb-6"><?= $mural['titulo'] ?></h5>
                                        <p class="card-text text-white mx-auto text-sm"><?= $mural['texto'] ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>

    </div>

</div>