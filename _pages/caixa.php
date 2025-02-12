<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Caixa de entrada</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="/caixa-de-entrada/" class="d-flex align-items-center gap-1 hover-text-primary">
                    <i class="fa-solid fa-envelope mx-2"></i>
                    Caixa de entrada
                </a>
            </li>

        </ul>
    </div>

    <div class="row gy-4">
        <?= $mensagem_caixaDeEntrada ?? "" ?>
        <div class="col-xxl-3">
            <div class="card h-100 p-0">
                <div class="card-body p-24">
                    <div class="mt-16">
                        <ul>
                            <li class="<?= $active_caixa ?? "" ?> mb-4">
                                <a href="/caixa-de-entrada" class="bg-hover-primary-50 px-12 py-8 w-100 radius-8 text-secondary-light">
                                    <span class="d-flex align-items-center gap-10 justify-content-between w-100">
                                        <span class="d-flex align-items-center gap-10">
                                            <span class="icon text-xxl line-height-1 d-flex"><iconify-icon icon="uil:envelope" class="icon line-height-1"></iconify-icon></span>
                                            <span class="fw-semibold">caixa</span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="<?= $active_aviso ?? "" ?> mb-4">
                                <a href="/caixa-de-entrada/avisos" class="bg-hover-primary-50 px-12 py-8 w-100 radius-8 text-secondary-light">
                                    <span class="d-flex align-items-center gap-10 justify-content-between w-100">
                                        <span class="d-flex align-items-center gap-10">
                                            <span class="icon text-xxl line-height-1 d-flex"><i class="fa-solid fa-triangle-exclamation"></i></span>
                                            <span class="fw-semibold">Avisos</span>
                                        </span>
                                        <span class="fw-medium"></span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <?php if (empty($sub_pagina)) {
            include('_modulos/caixa/principal.php');
        }
        if (!empty($sub_pagina) && $sub_pagina === 'avisos') {
            include('_modulos/caixa/avisos.php');
        }
        ?>
    </div>
</div>