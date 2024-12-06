<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Mural</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="mural/" class="d-flex align-items-center gap-1 hover-text-primary">
                    <i class="fa-solid fa-plus"></i>
                    Mural
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Cadastro</li>
        </ul>
    </div>

    <div class="card h-100 p-0 radius-12 overflow-hidden">
        <div class="card-body p-40">
            <form action="#">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-20">
                            <label for="titulo" class="form-label fw-semibold text-primary-light text-sm mb-8">Título<span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8" id="titulo" name="titulo" placeholder="Título do poste">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-20">
                            <label for="email" class="form-label fw-semibold text-primary-light text-sm mb-8">Um pequeno texto do poste <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8" id="texto" name="texto" placeholder="Enter email address">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-20">
                            <label for="country" class="form-label fw-semibold text-primary-light text-sm mb-8">Tipo de poste <span class="text-danger-600">*</span> </label>
                            <select class="form-control radius-8 form-select" id="tipos_mural">
                                <option selected disabled>Selecione o tipo...</option>
                                <option value="unico">Imagem única (768x455)</option>
                                <option value="carrosel">Carrosel (768x455)</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-center my-5">
                        <div class="col-sm-6" id="mural_unico" style="display: none;">
                            <div class="card p-0 overflow-hidden position-relative radius-12">
                                <div class="row card-header py-16 px-24 bg-base border border-end-0 border-start-0 border-top-0 d-flex justify-content-between align-items-center">
                                    <div class="col-10">
                                        <h6 class="text-lg mb-0 col-8 mural-titulo"></h6>
                                    </div>
                                </div>
                                <div class="card-body p-0 default-carousel">
                                    <div class="gradient-overlay bottom-0 start-0 h-100">
                                        <img src="assets/images/carousel/carousel-img3.png" alt="" class="w-100 h-100 object-fit-cover">
                                        <div class="position-absolute start-50 translate-middle-x bottom-0 pb-24 z-1 text-center w-100 max-w-440-px">
                                            <h5 class="card-title text-white text-lg mb-6 mural-titulo"></h5>
                                            <p class="card-text text-white mx-auto text-sm mural-texto"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6" id="mural_carrosel" style="display: none;">
                            <div class="card p-0 overflow-hidden position-relative radius-12">
                                <div class="row card-header py-16 px-24 bg-base border border-end-0 border-start-0 border-top-0 d-flex justify-content-between align-items-center">
                                    <div class="col-10">
                                        <h6 class="text-lg mb-0 col-8 mural-titulo"></h6>
                                    </div>
                                </div>
                                <div class="card-body p-0 arrow-carousel">
                                    <div class="gradient-overlay bottom-0 start-0 h-100">
                                        <img src="assets/images/carousel/carousel-img3.png" alt="" class="w-100 h-100 object-fit-cover">
                                        <div class="position-absolute start-50 translate-middle-x bottom-0 pb-24 z-1 text-center w-100 max-w-440-px">
                                            <h5 class="card-title text-white text-lg mb-6 mural-titulo"></h5>
                                            <p class="card-text text-white mx-auto text-sm mural-texto"></p>
                                        </div>
                                    </div>
                                    <div class="gradient-overlay bottom-0 start-0 h-100">
                                        <img src="assets/images/carousel/carousel-img3.png" alt="" class="w-100 h-100 object-fit-cover">
                                        <div class="position-absolute start-50 translate-middle-x bottom-0 pb-24 z-1 text-center w-100 max-w-440-px">
                                            <h5 class="card-title text-white text-lg mb-6 mural-titulo"></h5>
                                            <p class="card-text text-white mx-auto text-sm mural-texto"></p>
                                        </div>
                                    </div>
                                    <div class="gradient-overlay bottom-0 start-0 h-100">
                                        <img src="assets/images/carousel/carousel-img3.png" alt="" class="w-100 h-100 object-fit-cover">
                                        <div class="position-absolute start-50 translate-middle-x bottom-0 pb-24 z-1 text-center w-100 max-w-440-px">
                                            <h5 class="card-title text-white text-lg mb-6 mural-titulo"></h5>
                                            <p class="card-text text-white mx-auto text-sm mural-texto"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                        <button type="submit" class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8">
                            Criar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const muralSelect = document.getElementById('tipos_mural');
    const muralunico = document.getElementById('mural_unico');
    const muralcarrosel = document.getElementById('mural_carrosel');
    const tituloInput = document.getElementById('titulo');
    const textoInput = document.getElementById('texto');
    const muralTitulo = document.querySelectorAll('.mural-titulo');
    const muralTexto = document.querySelectorAll('.mural-texto');

    muralSelect.addEventListener('change', function() {
        if (this.value === 'unico') {
            muralunico.style.display = 'block';
            muralcarrosel.style.display = 'none';
            muralslide.style.display = 'none';
        } else if (this.value === 'carrosel') {
            muralunico.style.display = 'none';
            muralcarrosel.style.display = 'block';
            muralslide.style.display = 'none';
        }
    });

    tituloInput.addEventListener("input", function() {
        muralTitulo.forEach(function(mural) {
            mural.textContent = tituloInput.value;
        });
    });

    textoInput.addEventListener("input", function() {
        muralTexto.forEach(function(mural) {
            mural.textContent = textoInput.value;
        });
    });
</script>