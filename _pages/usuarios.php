<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Lista de Usuários</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                    <i class="fa-solid fa-users"></i>
                    Painel
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Lista de Usuários</li>
        </ul>
    </div>

    <div class="card h-100 p-0 radius-12">
        <div class="py-16 px-24">

        </div>
        <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="d-flex align-items-center flex-wrap gap-3">
                <select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px" id="select_status" onchange="location = this.value;">
                    <option selected disabled>Filtrar por status...</option>
                    <option value="/usuarios/ativos">Ativos</option>
                    <option value="/usuarios/inativos">Inativos</option>
                    <option value="/usuarios/deletados">Deletados</option>
                </select>
                <select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px" id="select_cargos" onchange="location = this.value;">
                    <option selected disabled>Filtrar por cargo...</option>
                    <option value="/usuarios/startufc">Equipe StartUFC</option>
                    <option value="/usuarios/membros">Membros</option>
                    <option value="/usuarios/responsaveis">Responsáveis</option>
                </select>
            </div>
            <a href="usuarios/cadastrar" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
                <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                Adicionar Novo Usuário
            </a>
        </div>
        <div class="card-body p-24">
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
                            <th scope="col" class="text-center">Data de cadastro</th>
                            <th scope="col" class="text-center">Cargo</th>
                            <th scope="col" class="text-center">StartUP</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col" class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario) { ?>
                            <tr class="linha_usuario">
                                <td>
                                    <div class="d-flex align-items-center gap-10">
                                        <?= "# " . $usuario['id'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= $usuario['imagemPerfil'] ?>" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                                        <div class="flex-grow-1">
                                            <span class="linha_nome_usuario text-md mb-0 fw-normal text-secondary-light"><?= $usuario['nome'] . " " . $usuario['sobrenome'] ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="text-md mb-0 fw-normal text-secondary-light"><?= $usuario['email'] ?></span></td>
                                <td><?= (new DateTime($usuario['dataCadastro']))->format('d/m/Y') ?></td>
                                <td class="text-center">
                                    <?php if ($usuario['nivel'] == 1) { ?>
                                        <span class="cargo bg-info-focus text-info-600 border border-info-main px-24 py-4 radius-4 fw-medium text-sm">Membro</span>
                                    <?php } ?>
                                    <?php if ($usuario['nivel'] == 2) { ?>
                                        <span class="cargo bg-warning-200 text-warning-600 border border-warning-400 px-24 py-4 radius-4 fw-medium text-sm">Responsável</span>
                                    <?php } ?>
                                    <?php if ($usuario['nivel'] == 3) { ?>
                                        <span class="cargo bg-neutral-200 text-neutral-600 border border-neutral-400 px-24 py-4 radius-4 fw-medium text-sm">Administrador</span>
                                    <?php } ?>
                                    <?php if ($usuario['nivel'] == 4) { ?>
                                        <span class="cargo bg-success-200 text-success-600 border border-success-400 px-24 py-4 radius-4 fw-medium text-sm">Bolsista StartUFC</span>
                                    <?php } ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    if ($usuario['startup'] == 0) {
                                        echo '<span class="text-danger-600">Sem StartUP</span>';
                                    } elseif ($usuario['nivel'] == 3 || $usuario['nivel'] == 4) {
                                        echo '<span class="text-success-600">UFC</span>';
                                    } else {
                                        echo '<span class="text-info-600">' . $usuario['nome_startup'] . '</span>';
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($usuario['ativo'] == 1) { ?>
                                        <span class="status bg-success-focus text-success-600 border border-success-main px-24 py-4 radius-4 fw-medium text-sm">Ativo</span>
                                    <?php } ?>
                                    <?php if ($usuario['ativo'] == 2) { ?>
                                        <span class="status bg-neutral-200 text-neutral-600 border border-neutral-400 px-24 py-4 radius-4 fw-medium text-sm">Inativo</span>
                                    <?php } ?>
                                    <?php if ($usuario['ativo'] == 3) { ?>
                                        <span class="status bg-danger-200 text-danger-600 border border-danger-400 px-24 py-4 radius-4 fw-medium text-sm">Deletado</span>
                                    <?php } ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($usuario['ativo'] != 3) { ?>
                                        <div class="d-flex align-items-center gap-10 justify-content-center">
                                            <a href="usuarios/<?= $usuario['id'] ?>/detalhes" class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                                            </a>
                                            <button type="button" data-bs-toggle="modal"
                                                data-id-usuario="<?= $usuario['id'] ?>"
                                                data-nome-usuario="<?= $usuario['nome'] . " " . $usuario['sobrenome'] ?>"
                                                data-email-usuario="<?= $usuario['email'] ?>"
                                                data-acao-form='<?= $usuario['ativo'] == 1 ? 'Desativar' : 'Ativar' ?>'
                                                data-bs-target="#usuario-ativo-modal" class="btn_desativar bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                            </button>

                                            <?php if ($usuario['nivel'] == 4 && $usuario['nivel'] != 4) { ?>
                                                <button type="button" data-bs-toggle="modal"
                                                    data-id-usuario="<?= $usuario['id'] ?>"
                                                    data-nome-usuario="<?= $usuario['nome'] . " " . $usuario['sobrenome'] ?>"
                                                    data-email-usuario="<?= $usuario['email'] ?>"
                                                    data-acao-form='Apagar'
                                                    data-bs-target="#usuario-apagar-modal" class="btn_deletar bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                    <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                                </button>
                                            <?php } ?>
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
                <span>mostrando a pagina <?= $pg_atual ?> de <?= $total_pg ?> com <?= $quant_por_pagina ?> usuários cada</span>
                <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                    <?php if ($pg_atual > 1) { ?>
                        <li class="page-item">
                            <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="<?= 'usuarios/pagina/' . ($pg_atual - 1) . '/' . $quant_por_pagina . '/' . $complemento_url ?>"><iconify-icon icon="ep:d-arrow-left" class=""></iconify-icon></a>
                        </li>
                    <?php } ?>

                    <?php for ($i = $start; $i <= $end; $i++) { ?>
                        <?php if ($i == $pg_atual) { ?>
                            <li class="page-item">
                                <a class="page-link text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md bg-primary-600 text-white" href="<?= 'usuarios/pagina/' . $i . '/' . $quant_por_pagina . '/' . $complemento_url ?>"><?= $i ?></a>
                            </li>
                        <?php } else { ?>
                            <li class="page-item">
                                <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px" href="<?= 'usuarios/pagina/' . $i . '/' . $quant_por_pagina . '/' . $complemento_url ?>"><?= $i ?></a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                    <?php if ($pg_atual < $total_pg) { ?>
                        <li class="page-item">
                            <a class="page-link bg-neutral-300 text-secondary-light fw-semibold radius-8 border-0 d-flex align-items-center justify-content-center h-32-px w-32-px " href="<?= 'usuarios/pagina/' . ($pg_atual + 1) . '/' . $quant_por_pagina . '/' . $complemento_url ?>"> <iconify-icon icon="ep:d-arrow-right" class=""></iconify-icon> </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>