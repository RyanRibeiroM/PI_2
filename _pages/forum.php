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
    <div class="mb-24">
        <?= $mensagem_forum ?? "" ?>
    </div>

    <div class="chat-wrapper">
        <div class="chat-sidebar card">
            <div class="chat-sidebar-single active top-profile">
                <div class="info">
                    <h6 class="text-md mb-0">Fóruns</h6>
                </div>

            </div>
            <div class="chat-all-list">
            </div>
        </div>
        <div class="chat-main card">
            <div class="chat-sidebar-single active">
                <div class="info">
                    <?php if (!empty($forum)) { ?>
                        <h6 class="text-md mb-0"><?= $forum['nome'] ?></h6>
                    <?php } else { ?>
                        <i class="text-md mb-0">selecione um fórum</i>
                    <?php } ?>
                </div>
                <?php if ($usuarioLogado['nivel'] == 3 && !empty($id_forum)) { ?>
                    <div class="action d-inline-flex align-items-center gap-3">
                        <div class="btn-group">
                            <button type="button" class="text-primary-light text-xl" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                <iconify-icon icon="tabler:dots-vertical"></iconify-icon>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-lg-end border">
                                <li>
                                    <form method="post">
                                        <input type="hidden" name="id_forum" value="<?= $id_forum ?>">
                                        <button class="d-flex align-items-center dropdown-item rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900" type="submit" name="excluir_mensagem_forum">
                                            <iconify-icon icon="mdi:clear-circle-outline"></iconify-icon>
                                            <span class="ms-2">Limpar todas as mensagens</span>
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#teste" class="d-flex align-items-center dropdown-item rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900" type="button">
                                        <iconify-icon icon="ic:baseline-block"></iconify-icon>
                                        <span class="ms-2">Gerenciar Acesso</span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="chat-message-list">
                <div class="text-center" id="emptyMessage" style="display: none;">
                    <img src="assets/images/chat/empty-img.png" alt="image">
                    <h6 class="mb-1 mt-16">Sem Mensagem...</h6>
                    <p class="mb-0 text-sm">Nenhum mensagem encontrada nesse chat!</p>
                </div>
            </div>
            <?php if (!empty($forum)) { ?>
                <form class="chat-message-box" id="chatForm">
                    <input type="text" name="mensagem" id="mensagemInput" placeholder="Escreva a Mensagem" required autocomplete="off">
                    <div class="chat-message-box-action">
                        <button type="submit" class="btn btn-sm btn-primary-600 radius-8 d-inline-flex align-items-center gap-1">
                            Enviar
                            <iconify-icon icon="f7:paperplane"></iconify-icon>
                        </button>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
    <script>
        <?php if (!empty($id_forum)) { ?>
            var id_forum = <?= $id_forum ?>;
        <?php } ?>
        var id_usuario = <?= $usuarioLogado['id'] ?>;
    </script>

</div>