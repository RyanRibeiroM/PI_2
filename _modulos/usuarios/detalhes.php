<div class="dashboard-main-body">
    <div
        class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Add User</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a
                    href="usuarios/"
                    class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon
                        icon="solar:home-smile-angle-outline"
                        class="icon text-lg"></iconify-icon>
                    Usuários
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Detalhes</li>
        </ul>
    </div>

    <div class="card h-100 p-0 radius-12">
        <div class="card-body p-24">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-xl-8 col-lg-10">
                    <div class="card border">
                        <div class="card-body">
                            <h6 class="text-md text-primary-light mb-16">
                                Profile Image
                            </h6>

                            <!-- Upload Image Start -->
                            <div class="mb-24 mt-16">
                                <div class="avatar-upload">
                                    <div class="avatar-preview">
                                        <div id="imagePreview"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Upload Image End -->

                            <form action="#">
                                <div class="mb-20">
                                    <label
                                        for="name"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Nome Completo
                                        <span class="text-danger-600">*</span></label>
                                    <input
                                        type="text"
                                        class="form-control radius-8"
                                        id="nome"
                                        name="nome"
                                        value="<?= $detalhesUsuario['nome'] . " " . $detalhesUsuario['sobrenome'] ?>" />
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
                                        placeholder="Email do usuario"
                                        value="<?= $detalhesUsuario['email'] ?>" />
                                </div>
                                <div class="mb-20">
                                    <label
                                        for="telefone"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">telefone</label>
                                    <input
                                        type="text"
                                        class="form-control radius-8"
                                        id="telefone"
                                        name="telefone"
                                        placeholder="Enter phone number"
                                        value="<?= $detalhesUsuario['telefone'] ?>" />
                                </div>
                                <div class="mb-20">
                                    <label
                                        for="desig"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">StartUP do Usuário <span class="text-danger-600">*</span>
                                    </label>
                                    <select
                                        class="form-control radius-8 form-select"
                                        id="startup"
                                        name="startup">
                                        <?php foreach ($startups as $startup) { ?>
                                            <option value="<?= $startup['id'] ?>" <?= ($startup['id'] === $detalhesUsuario['startup'] ? "selected" : "") ?>><?= $startup['nome'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div
                                    class="d-flex align-items-center justify-content-center gap-3">
                                    <button
                                        type="submit"
                                        class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                        Salvar Alterações
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