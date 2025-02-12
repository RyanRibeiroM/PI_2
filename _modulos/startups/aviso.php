<div class="dashboard-main-body">
    <div
        class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Adicionar Aviso</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a
                    href="index.html"
                    class="d-flex align-items-center gap-1 hover-text-primary">
                    <i class="fa-solid fa-warning"></i>
                    Startup
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Adicionar Aviso</li>
        </ul>
    </div>

    <div class="card h-100 p-0 radius-12">
        <div class="p-24">
            <?= $mensagem_cadastro_aviso ?? "" ?>
            <?= $teste ?? "" ?>
        </div>
        <div class="card-body p-24">
            <div class="row justify-content-center">
                <div class="card-body">
                    <form method="post">
                        <div class="row">
                            <div class="col-lg-6 mb-20">
                                <label
                                    for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Assunto do Aviso
                                    <span class="text-danger-600">*</span></label>
                                <input
                                    type="text"
                                    class="form-control radius-8"
                                    name="assunto"
                                    id="assunto"
                                    placeholder="Assunto" />
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
                            <div class="col-lg-12 mb-20">
                                <label
                                    for="descricao"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Descrição<span class="text-danger-600">*</span>
                                </label>
                                <textarea
                                    name="descricao"
                                    class="form-control"
                                    rows="4"
                                    cols="50"
                                    placeholder="Descrição..."></textarea>
                            </div>
                            <div class="col-lg-12 mb-20 mt-5" id="containerStartups">
                                <div class="card h-100 p-0">
                                    <label
                                        for="depart"
                                        class="form-label fw-semibold text-primary-light text-sm">Selecione as Startups para qual o aviso deve ser enviado<span class="text-danger-600">*</span>
                                    </label>
                                    <div class="card-body p-24">
                                        <div class="d-flex align-items-center flex-wrap gap-28">
                                            <?php foreach ($startups as $startup) { ?>
                                                <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                                    <input class="form-check-input" type="checkbox" role="switch" name="startup[<?= $startup['id'] ?>]" value="<?= $startup['id'] ?>" checked>
                                                    <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="yes"><?= $startup['nome'] ?></label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="d-flex align-items-center justify-content-center gap-3">
                            <button
                                type="submit"
                                class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8"
                                name="cadastrarAviso">
                                Enviar
                            </button>
                        </div>
                    </form>
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