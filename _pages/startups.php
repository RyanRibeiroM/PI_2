<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Startups</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                    <i class="fa-solid fa-rocket"></i>
                    StartUFC
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Startups</li>
        </ul>
    </div>

    <div class="card h-100 p-0 radius-12">
        <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="d-flex align-items-center flex-wrap gap-3">
                <select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px" id="select_status" onchange="location = this.value;">
                    <option selected disabled>Filtrar por status...</option>
                    <option value="/startups/ativos">Ativos</option>
                    <option value="/startups/inativos">Inativos</option>
                    <option value="/startups/deletados">Deletados</option>
                </select>
            </div>
        </div>
        <div class="card-body p-24">
            <div class="table-responsive scroll-sm">
                <table class="table bordered-table sm-table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">
                                <div class="d-flex align-items-center gap-10">
                                </div>
                                ID
            </div>
            </th>
            <th scope="col">Logo</th>
            <th scope="col">Nome</th>
            <th scope="col">Responsavel</th>
            <th scope="col">Membros</th>
            <th scope="col">CNPJ</th>
            <th scope="col" class="text-center">Status</th>
            <th scope="col" class="text-center">Ações</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($startups as $startup) { ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-10">
                                <?= $startup['id'] ?>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-10">
                                <img src="<?= $startup['imagem'] ?? "" ?>" alt="<?= $startup["nome"] ?>" class="w-40-px h-40-px flex-shrink-0 me-12 overflow-hidden">
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <span class="text-md mb-0 fw-normal text-secondary-light"><?= $startup["nome"] ?></span>
                                </div>
                            </div>
                        </td>
                        <td><span class="text-md mb-0 fw-normal text-secondary-light"><?= $startup['nome_responsavel'] ?? "" ?></span></td>
                        <td><?= $startup['membros'] ?? "0" ?></td>
                        <td><?= $startup['cnpj'] ?? "" ?></td>
                        <td class="text-center">
                            <?php if ($startup['ativo'] == 1) { ?>
                                <span class="bg-success-focus text-success-600 border border-success-main px-24 py-4 radius-4 fw-medium text-sm">Ativo</span>
                            <?php } ?>
                            <?php if ($startup['ativo'] == 2) { ?>
                                <span class="bg-neutral-200 text-neutral-600 border border-neutral-400 px-24 py-4 radius-4 fw-medium text-sm">Inativo</span>
                            <?php } ?>
                            <?php if ($startup['ativo'] == 3) { ?>
                                <span class="bg-danger-200 text-danger-600 border border-danger-400 px-24 py-4 radius-4 fw-medium text-sm">Deletada</span>
                            <?php } ?>
                        </td>
                        <td class="text-center">
                            <?php if ($startup['ativo'] != 3) { ?>
                                <div class="d-flex align-items-center gap-10 justify-content-center">
                                    <button type="button" data-bs-toggle="modal"
                                        data-id-startup="<?= $startup['id'] ?>"
                                        data-nome-startup="<?= $startup['nome'] ?>"
                                        data-cnpj-startup="<?= $startup['cnpj'] ?>"
                                        data-acao-form='<?= $startup['ativo'] == 1 ? 'Desativar' : 'Ativar' ?>'
                                        data-bs-target="#startup-ativo-modal" class="btn_desativar bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                        <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                    </button>
                                    <button type="button" data-bs-toggle="modal"
                                        data-id-startup="<?= $startup['id'] ?>"
                                        data-nome-startup="<?= $startup['nome'] ?>"
                                        data-cnpj-startup="<?= $startup['cnpj'] ?>"
                                        data-acao-form='Apagar'
                                        data-bs-target="#startup-apagar-modal" class="btn_deletar bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                        <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                    </button>
                                </div>
                            <?php } else {
                                echo 'Sem ações';
                            } ?>
                        </td>
                    </tr>
                <?php } ?>

            </tbody>
            </table>
        </div>

        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
            <span>mostrando a pagina <?= $pg_atual ?> de <?= $total_pg ?> com <?= $quant_por_pagina ?> startups cada</span>
            <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                <?php if ($pg_atual > 1) { ?>
                    <li class="page-item">
                        <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="<?= 'startups/pagina/' . ($pg_atual - 1) . '/' . $quant_por_pagina . '/' . $complemento_url ?>"><iconify-icon icon="ep:d-arrow-left" class=""></iconify-icon></a>
                    </li>
                <?php } ?>

                <?php for ($i = $start; $i <= $end; $i++) { ?>
                    <?php if ($i == $pg_atual) { ?>
                        <li class="page-item">
                            <a class="page-link text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md bg-primary-600 text-white" href="<?= 'startups/pagina/' . $i . '/' . $quant_por_pagina . '/' . $complemento_url ?>"><?= $i ?></a>
                        </li>
                    <?php } else { ?>
                        <li class="page-item">
                            <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px" href="<?= 'startups/pagina/' . $i . '/' . $quant_por_pagina . '/' . $complemento_url ?>"><?= $i ?></a>
                        </li>
                    <?php } ?>
                <?php } ?>
                <?php if ($pg_atual < $total_pg) { ?>
                    <li class="page-item">
                        <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px " href="<?= 'startups/pagina/' . ($pg_atual + 1) . '/' . $quant_por_pagina . '/' . $complemento_url ?>"> <iconify-icon icon="ep:d-arrow-right" class=""></iconify-icon> </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
</div>