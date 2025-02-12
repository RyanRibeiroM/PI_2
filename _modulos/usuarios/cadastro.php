<div class="dashboard-main-body">
    <div
        class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Adicionar Usuário</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a
                    href="index.html"
                    class="d-flex align-items-center gap-1 hover-text-primary">
                    <i class="fa-solid fa-plus"></i>
                    Usuários
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Adicionar Usuários</li>
        </ul>
    </div>

    <div class="card h-100 p-0 radius-12">
        <div class="p-24">
            <?= $mensagem_cadastro_usuario ?? "" ?>
        </div>
        <div class="card-body p-24">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-xl-8 col-lg-10">
                    <div class="card border">
                        <div class="card-body">
                            <form method="post">
                                <div class="mb-20">
                                    <label
                                        for="name"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Nome Completo
                                        <span class="text-danger-600">*</span></label>
                                    <input
                                        type="text"
                                        class="form-control radius-8"
                                        name="nome"
                                        id="nome"
                                        placeholder="Nome Completo"
                                        value="<?= $_POST['nome'] ?? "" ?>" />
                                </div>
                                <div class="mb-20">
                                    <label
                                        for="email"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Email <span class="text-danger-600">*</span></label>
                                    <input
                                        type="email"
                                        class="form-control radius-8"
                                        id="email"
                                        name="email"
                                        value="<?= $_POST['email'] ?? "" ?>"
                                        placeholder="Endereço de Email" />
                                </div>
                                <div class="mb-20">
                                    <label
                                        for="telefone"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Telefone
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control radius-8"
                                        id="telefone"
                                        name="telefone"
                                        value="<?= $_POST['telefone'] ?? "" ?>"
                                        placeholder="Número de Telefone" />
                                </div>
                                <div class="mb-20">
                                    <label for="senha" class="form-label fw-semibold text-primary-light text-sm mb-8">Senha <span class="text-danger-600">*</span></label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control radius-8" id="senha" name="senha" placeholder="Senha">
                                        <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#senha"></span>
                                    </div>
                                </div>
                                <div class="mb-20">
                                    <label for="confirmarSenha" class="form-label fw-semibold text-primary-light text-sm mb-8">Confirmar Senha <span class="text-danger-600">*</span></label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control radius-8" id="confirmarSenha" name="confirmarSenha" placeholder="Confirmar Senha">
                                        <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#confirmarSenha"></span>
                                    </div>
                                </div>
                                <div class="mb-20">
                                    <label
                                        for="depart"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Cargo <span class="text-danger-600">*</span>
                                    </label>
                                    <select
                                        class="form-control radius-8 form-select"
                                        id="cargo" name="cargo">
                                        <option selected disabled>Selecione o Cargo</option>
                                        <option value="membrostartup">Membro de startup</option>
                                        <option value="equipestartufc">Equipe StartUFC</option>
                                    </select>
                                </div>
                                <div id="startupSelectContainer" class="mb-20" style="display: none;">
                                    <label
                                        for="startup"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Selecione a Startup
                                    </label>
                                    <select
                                        class="form-control radius-8 form-select"
                                        id="startup"
                                        name="startups">
                                        <option selected disabled> Selecione a startup</option>
                                        <option value="naocadastrado">Startup ainda não cadastrada</option>
                                        <?php foreach ($startups as $startup) { ?>
                                            <option value="<?= $startup['id'] ?>"><?= $startup['nome'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div
                                    class="d-flex align-items-center justify-content-center gap-3">
                                    <button
                                        type="submit"
                                        class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8"
                                        name="cadastrarUsuario">
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



<script>
    const cargoSelect = document.getElementById('cargo');
    const startupSelectContainer = document.getElementById('startupSelectContainer');

    cargoSelect.addEventListener('change', function() {
        if (this.value === 'membrostartup') {
            startupSelectContainer.style.display = 'block';
        } else {
            startupSelectContainer.style.display = 'none';
        }
    });
</script>