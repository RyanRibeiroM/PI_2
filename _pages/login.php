<section class="auth bg-base d-flex flex-wrap">
    <div class="auth-left d-lg-block d-none">
        <div class="d-flex align-items-center flex-column h-100 justify-content-center">
            <img src="assets/images/capa.webp" class="w-100" alt="">
        </div>
    </div>
    <div class="auth-right px-24 d-flex flex-column justify-content-center">
        <div class="max-w-464-px mx-auto w-100">
            <div>
                <div><?php if (isset($_SESSION['mensagemSucesso']) && $mensagem == "") {
                            echo $_SESSION['mensagemSucesso'] ?? "";
                        } else {
                            echo $mensagem ?? "";
                        } ?></div>
                <h4 class="mb-12">Faça login na sua conta</h4>
                <p class="mb-32 text-secondary-light text-lg">Bem vindo de volta! por favor insira seus dados</p>
            </div>
            <form method="post">
                <div class="icon-field mb-16">
                    <span class="icon top-50 translate-middle-y">
                        <iconify-icon icon="mage:email"></iconify-icon>
                    </span>
                    <input type="email" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Email" name="email_usuario" value="<?= $_POST["email_usuario"] ?? "" ?>">
                </div>
                <div class="position-relative mb-20">
                    <input type="text" name="campoNulo" style="display:none;">
                    <input type="hidden" name="token" value="<?= $_SESSION["token"] ?>">
                    <input type="hidden" name="tempoEnvioForm" value="<?= time() ?>">
                    <div class="icon-field">
                        <span class="icon top-50 translate-middle-y">
                            <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                        </span>
                        <input type="password" class="form-control h-56-px bg-neutral-50 radius-12" id="your-password" placeholder="Password" name="senha" value="">
                    </div>
                    <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#your-password"></span>
                </div>

                <button type="submit" class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32" name="entrar"> ENTRAR</button>

            </form>
        </div>
    </div>
</section>