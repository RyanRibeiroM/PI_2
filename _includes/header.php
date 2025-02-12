<aside class="sidebar">
  <button type="button" class="sidebar-close-btn">
    <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
  </button>
  <div>
    <a href="/" class="sidebar-logo">
      <img src="assets/images/logo2.svg" alt="site logo" class="light-logo">
      <img src="assets/images/logo2.svg" alt="site logo" class="dark-logo">
      <img src="assets/images/logo2.svg" alt="site logo" class="logo-icon">
    </a>
  </div>
  <div class="sidebar-menu-area">
    <ul class="sidebar-menu" id="sidebar-menu">
      <li class="sidebar-menu-group-title">Menu</li>
      <li>
        <a href="/home/">
          <i class="fa-solid fa-house menu-icon"></i>
          <span>Pagina Inicial</span>
        </a>
      </li>
      <li>
        <a href="/perfil/">
          <i class="fa-solid fa-user menu-icon"></i>
          <span>Perfil</span>
        </a>
      </li>
      <li>
        <a href="/caixa-de-entrada/">
          <i class="fa-solid fa-envelope menu-icon"></i>
          <span>Caixa de entrada</span>
        </a>
      </li>

      <?php if ($usuarioLogado['nivel'] === 3 || $usuarioLogado['nivel'] === 4) { ?>
        <li class="dropdown">
          <a href="javascript:void(0)">
            <i class="fa-solid fa-rocket menu-icon"></i>
            <span>Startups</span>
          </a>
          <ul class="sidebar-submenu">
            <li>
              <a href="startups/"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Lista de Startups</a>
            </li>
            <li>
              <a href="startups/cadastrar/"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Adicionar Startup</a>
            </li>
            <li>
              <a href="startups/adicionar-aviso/"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Adicionar Aviso</a>
            </li>
            <li>
              <a href="startups/minha-startup/"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Minha Startup</a>
            </li>
          </ul>
        </li>
      <?php } else if ($usuarioLogado['nivel'] === 2) { ?>
        <li class="dropdown">
          <a href="javascript:void(0)">
            <i class="fa-solid fa-rocket menu-icon"></i>
            <span>Startup</span>
          </a>
          <ul class="sidebar-submenu">
            <li>
              <a href="startups/minha-startup/"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Minha Startup</a>
            </li>
            <li>
              <a href="startups/adicionar-aviso/"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Adicionar Aviso</a>
            </li>
          </ul>
        </li>
      <?php } else { ?>
        <li>
          <a href="startups/minha-startup">
            <i class="fa-solid fa-rocket menu-icon"></i>
            <span>Minha Startup</span>
          </a>
        </li>
      <?php } ?>
      <?php if ($usuarioLogado['nivel'] === 3) { ?>
        <li class="dropdown">
          <a href="javascript:void(0)">
            <i class="fa-solid fa-users menu-icon"></i>
            <span>Usuários</span>
          </a>
          <ul class="sidebar-submenu">
            <li>
              <a href="usuarios/"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Lista de usuários</a>
            </li>
            <li>
              <a href="usuarios/cadastrar"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Adicionar usuários</a>
            </li>
          </ul>
        </li>
      <?php } ?>
      <?php if ($usuarioLogado['nivel'] === 4) { ?>
        <li class="dropdown">
          <a href="javascript:void(0)">
            <i class="fa-solid fa-users menu-icon"></i>
            <span>Usuários</span>
          </a>
          <ul class="sidebar-submenu">
            <li>
              <a href="usuarios/"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Lista de usuários</a>
            </li>
          </ul>
        </li>
      <?php } ?>
      <?php if ($usuarioLogado['nivel'] === 3 || $usuarioLogado['nivel'] === 2 || $usuarioLogado['nivel'] === 4) { ?>
        <li>
          <a href="/mural/">
            <i class="fa-solid fa-panorama menu-icon"></i>
            <span>Mural</span>
          </a>
        </li>
      <?php } ?>
      <li>
        <a href="/forum/">
          <i class="fa-solid fa-comments menu-icon"></i>
          <span>Fórum</span>
        </a>
      </li>
    </ul>
  </div>
</aside>
<main class="dashboard-main">
  <div class="navbar-header">
    <div class="row align-items-center justify-content-between">
      <div class="col-auto">
        <div class="d-flex flex-wrap align-items-center gap-4">
          <button type="button" class="sidebar-toggle">
            <iconify-icon icon="heroicons:bars-3-solid" class="icon text-2xl non-active"></iconify-icon>
            <iconify-icon icon="iconoir:arrow-right" class="icon text-2xl active"></iconify-icon>
          </button>
          <button type="button" class="sidebar-mobile-toggle">
            <iconify-icon icon="heroicons:bars-3-solid" class="icon"></iconify-icon>
          </button>
        </div>
      </div>
      <div class="col-auto">
        <div class="d-flex flex-wrap align-items-center gap-3">
          <button type="button" data-theme-toggle class="w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center"></button>
          <div class="dropdown">
            <button class="has-indicator w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center" type="button" data-bs-toggle="dropdown">
              <i class="fa-solid fa-bell"></i>
            </button>
            <div class="dropdown-menu to-top dropdown-menu-lg p-0">
              <?php if (!empty($avisosMenu)) { ?>
                <div class="m-16 py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                  <div>
                    <h6 class="text-lg text-primary-light fw-semibold mb-0">Avisos</h6>
                  </div>
                  <span class="text-primary-600 fw-semibold text-lg w-40-px h-40-px rounded-circle bg-base d-flex justify-content-center align-items-center"><?= count($avisosMenu) ?></span>
                </div>
              <?php } else {
                echo '<div class="m-16 py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                <div>
                  <p class="text-lg text-primary-light fw-semibold mb-0">Os avisos apareceram aqui</p>
                </div></div>';
              } ?>
              <?php if (!empty($avisosMenu)) {
                foreach ($avisosMenu as $avisoMenu) { ?>
                  <div class="max-h-400-px overflow-y-auto scroll-sm pe-4">
                    <a href="/caixa-de-entrada/avisos/<?= $avisoMenu['id'] ?>/detalhes" class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between">
                      <div class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3">
                        <img src="<?= $avisoMenu['remetente_imagemPerfil'] ?>" alt="" class="w-40-px h-40-px rounded-pill">
                        <div>
                          <h6 class="text-md fw-semibold mb-4"><?= $avisoMenu['assunto'] ?></h6>
                          <p class="mb-0 text-sm text-secondary-light text-w-200-px"><?= $avisoMenu['conteudo'] ?></p>
                        </div>
                      </div>
                      <span class="text-sm text-secondary-light flex-shrink-0"><?= $avisoMenu['data_envio'] ?></span>
                    </a>
                  </div>
              <?php }
                echo '<div class="text-center py-12 px-16">
                <a href="javascript:void(0)" class="text-primary-600 fw-semibold text-md">Ver todas as Notificações</a>
              </div>';
              } else {
                echo '<div class="text-center py-12 px-16">
                <p class="text-secondary-light fw-medium text-md">Nenhuma notificação...</p></div>';
              } ?>

            </div>
          </div><!-- Notification dropdown end -->

          <div class="dropdown">
            <button class="d-flex justify-content-center align-items-center rounded-circle" type="button" data-bs-toggle="dropdown">
              <img src="<?= $usuarioLogado['imagemPerfil'] ?>" alt="image" class="w-40-px h-40-px object-fit-cover rounded-circle">
            </button>
            <div class="dropdown-menu to-top dropdown-menu-sm">
              <div class="py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                <div>
                  <h6 class="text-lg text-primary-light fw-semibold mb-2"><?= $usuarioLogado['nome'] ?></h6>
                  <?php if ($usuarioLogado['nivel'] == 3) { ?>
                    <span class="text-secondary-light fw-medium text-sm">Admin</span>
                  <?php } else if ($usuarioLogado['nivel'] == 4) { ?>
                    <span class="text-secondary-light fw-medium text-sm">Bolsista StartUFC</span>
                  <?php } else if ($usuarioLogado['nivel'] == 2) { ?>
                    <span class="text-secondary-light fw-medium text-sm">Responsável</span>
                  <?php } else { ?>
                    <span class="text-secondary-light fw-medium text-sm">Membro de Startup</span>
                  <?php } ?>
                </div>
              </div>
              <ul class="to-top-list">
                <li>
                  <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3" href="perfil/">
                    <iconify-icon icon="solar:user-linear" class="icon text-xl"></iconify-icon>Meu Perfil</a>
                </li>
                <li>
                  <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-danger d-flex align-items-center gap-3" href="sair/">
                    <iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon> sair</a>
                </li>
              </ul>
            </div>
          </div><!-- Profile dropdown end -->
        </div>
      </div>
    </div>
  </div>