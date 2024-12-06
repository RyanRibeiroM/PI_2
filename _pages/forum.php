<div class="dashboard-main-body">

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <div class="d-flex align-items-center gap-4">
            <h6 class="fw-semibold mb-0">Fórum</h6>
            <?php if ($usuarioLogado['nivel'] === 3) { ?>
                <a href="forum/cadastrar" class="btn btn-primary-600 radius-8 px-20 py-11"> + novo fórum</a>
            <?php } ?>
        </div>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="forum/" class="d-flex align-items-center gap-1 hover-text-primary">
                    <i class="fa-solid fa-comments"></i>
                    Fórum
                </a>
            </li>
        </ul>
    </div>

    <div class="chat-wrapper">
        <div class="chat-sidebar card">
            <div class="chat-sidebar-single active top-profile">
                <div class="info">
                    <h6 class="text-md mb-0">Fórum Principal</h6>
                </div>

            </div><!-- chat-sidebar-single end -->
            <div class="chat-search">
                <span class="icon">
                    <iconify-icon icon="iconoir:search"></iconify-icon>
                </span>
                <input type="text" name="#0" autocomplete="off" placeholder="Procurar Fórum...">
            </div>
            <div class="chat-all-list">
                <div class="chat-sidebar-single active">
                    <div class="info">
                        <h6 class="text-sm mb-1">Fórum Principal</h6>
                        <p class="mb-0 text-xs">Oi, Está gostando...</p>
                    </div>
                    <div class="action text-end">
                        <p class="mb-0 text-neutral-400 text-xs lh-1">12:30 PM</p>
                        <span class="w-16-px h-16-px text-xs rounded-circle bg-warning-main text-white d-inline-flex align-items-center justify-content-center">1</span>
                    </div>
                </div><!-- chat-sidebar-single end -->
                <div class="chat-sidebar-single active">
                    <div class="info">
                        <h6 class="text-sm mb-1">Fórum Secundário</h6>
                        <p class="mb-0 text-xs">Olá amigos...</p>
                    </div>
                    <div class="action text-end">
                        <p class="mb-0 text-neutral-400 text-xs lh-1">12:30 PM</p>
                        <span class="w-16-px h-16-px text-xs rounded-circle bg-warning-main text-white d-inline-flex align-items-center justify-content-center">8</span>
                    </div>
                </div><!-- chat-sidebar-single end -->
            </div>
        </div>
        <div class="chat-main card">
            <div class="chat-sidebar-single active">
                <div class="info">
                    <h6 class="text-md mb-0">Fórum Principal</h6>
                    <p class="mb-0"><strong>Criado por: </strong>Nome do criador</p>
                </div>
                <div class="action d-inline-flex align-items-center gap-3">
                    <div class="btn-group">
                        <button type="button" class="text-primary-light text-xl" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                            <iconify-icon icon="tabler:dots-vertical"></iconify-icon>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-lg-end border">
                            <li>
                                <button class="dropdown-item rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900" type="button">
                                    <iconify-icon icon="mdi:clear-circle-outline"></iconify-icon>
                                    Limpar tudo
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900" type="button">
                                    <iconify-icon icon="ic:baseline-block"></iconify-icon>
                                    Bloquear acesso
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!-- chat-sidebar-single end -->
            <div class="chat-message-list">
                <div class="chat-single-message left">
                    <img src="assets/images/usuarioPadrao.webp" alt="image" class="avatar-lg object-fit-cover rounded-circle">
                    <div class="chat-message-content">
                        <p class="mb-3">Oi, Está gostando do Fórum?</p>
                        <p class="chat-time mb-0">
                            <span>6.30 pm</span>
                        </p>
                    </div>
                </div><!-- chat-single-message end -->
                <div class="chat-single-message right">
                    <div class="chat-message-content">
                        <p class="mb-3">Sim, é bem interessante</p>
                        <p class="chat-time mb-0">
                            <span>6.30 pm</span>
                        </p>
                    </div>
                </div><!-- chat-single-message end -->
                <div class="chat-single-message left">
                    <img src="assets/images/usuarioPadrao.webp" alt="image" class="avatar-lg object-fit-cover rounded-circle">
                    <div class="chat-message-content">
                        <p class="mb-3">Que bom!</p>
                        <p class="chat-time mb-0">
                            <span>6.30 pm</span>
                        </p>
                    </div>
                </div><!-- chat-single-message end -->
            </div>
            <form class="chat-message-box">
                <input type="text" name="chatMessage" placeholder="Write message">
                <div class="chat-message-box-action">
                    <button type="submit" class="btn btn-sm btn-primary-600 radius-8 d-inline-flex align-items-center gap-1">
                        Enviar
                        <iconify-icon icon="f7:paperplane"></iconify-icon>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>