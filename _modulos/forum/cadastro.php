<div class="dashboard-main-body">
    <div
        class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Fórum</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a
                    href="forum/"
                    class="d-flex align-items-center gap-1 hover-text-primary">
                    <i class="fa-solid fa-warning"></i>
                    Fórum
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Novo Fórum</li>
        </ul>
    </div>

    <div class="card h-100 p-0 radius-12">
        <div class="p-24">
            <?= $mensagem_cadastro_aviso ?? "" ?>
        </div>
        <div class="card-body p-24">
            <div class="row justify-content-center">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mb-20">
                            <label
                                for="name"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Nome do Fórum
                                <span class="text-danger-600">*</span></label>
                            <input
                                type="text"
                                class="form-control radius-8"
                                name="titulo"
                                id="titulo"
                                placeholder="Título" />
                        </div>
                        <div class="col-lg-6 mb-20">
                            <label
                                for="todos-startups"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Mandar para todas as startUPs<span class="text-danger-600">*</span>
                            </label>
                            <select
                                class="form-control radius-8 form-select"
                                id="todos-startups" name="todos-startups">
                                <option selected value="sim">Sim</option>
                                <option value="nao">Não</option>
                            </select>
                        </div>
                        <div class="col-lg-12 mb-20 mt-5" id="containerStartups">
                            <div class="card h-100 p-0">
                                <label
                                    for="depart"
                                    class="form-label fw-semibold text-primary-light text-sm">Selecione as Startups que iram participar desse fórum<span class="text-danger-600">*</span>
                                </label>
                                <div class="card-body p-24">
                                    <div class="d-flex align-items-center flex-wrap gap-28">
                                        <?php foreach ($startups as $startup) { ?>
                                            <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                                <input class="form-check-input" type="checkbox" role="switch" name="startup[<?= $startup['id'] ?>]" value="<?= $startup['id'] ?>">
                                                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="yes"><?= $startup['nome'] ?></label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="d-flex align-items-center justify-content-center gap-3 mt-4">
                            <button
                                type="submit"
                                class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8"
                                name="cadastrarforum">
                                Cadastrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    const startupsSelect = document.getElementById('todos-startups');
    const startupSelectContainer = document.getElementById('containerStartups');
    startupSelectContainer.style.display = 'none';

    startupsSelect.addEventListener('change', function() {
        if (this.value === 'sim') {
            startupSelectContainer.style.display = 'none';
        } else {
            startupSelectContainer.style.display = 'block';
        }
    });
</script>