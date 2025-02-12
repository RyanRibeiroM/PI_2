<div class="dashboard-main-body">

  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Página Inicial</h6>
    <ul class="d-flex align-items-center gap-2">
      <li class="fw-medium">
        <a href="/" class="d-flex align-items-center gap-1 hover-text-primary">
          <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
          Página Inicial
        </a>
      </li>
    </ul>
  </div>

  <div class="row gy-4">
    <?php foreach ($murais as $mural) { ?>
      <?php if ($mural['tipo'] == 'unico') { ?>
        <div class="col-sm-6">
          <div class="card p-0 overflow-hidden position-relative radius-12">
            <div class="row card-header py-16 px-24 bg-base border border-end-0 border-start-0 border-top-0 d-flex justify-content-between align-items-center">
              <div class="col-10">
                <h6 class="text-lg mb-0 col-8"><?= $mural['titulo'] ?></h6>
              </div>
            </div>
            <div class="card-body p-0 default-carousel">
              <?php foreach ($mural['imagens'] as $imagem) { ?>
                <div class="gradient-overlay bottom-0 start-0 h-100">
                  <img src="<?= $imagem ?>" alt="" class="w-100 h-100 object-fit-cover">
                  <div class="position-absolute start-50 translate-middle-x bottom-0 pb-24 z-1 text-center w-100 max-w-440-px">
                    <h5 class="card-title text-white text-lg mb-6"><?= $mural['titulo'] ?></h5>
                    <p class="card-text text-white mx-auto text-sm"><?= $mural['texto'] ?></p>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      <?php } ?>
      <?php if ($mural['tipo'] == 'carrosel') { ?>
        <div class="col-sm-6">
          <div class="card p-0 overflow-hidden position-relative radius-12">
            <div class="row card-header py-16 px-24 bg-base border border-end-0 border-start-0 border-top-0 d-flex justify-content-between align-items-center">
              <div class="col-10">
                <h6 class="text-lg mb-0 col-8"><?= $mural['titulo'] ?></h6>
              </div>
            </div>
            <div class="card-body p-0 arrow-carousel">
              <?php foreach ($mural['imagens'] as $imagem) { ?>
                <div class="gradient-overlay bottom-0 start-0 h-100">
                  <img src="<?= $imagem ?>" alt="" class="w-100 h-100 object-fit-cover">
                  <div class="position-absolute start-50 translate-middle-x bottom-0 pb-24 z-1 text-center w-100 max-w-440-px">
                    <h5 class="card-title text-white text-lg mb-6"><?= $mural['titulo'] ?></h5>
                    <p class="card-text text-white mx-auto text-sm"><?= $mural['texto'] ?></p>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      <?php } ?>
    <?php } ?>
  </div>

</div>