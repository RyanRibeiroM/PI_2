# modais da pagina

```html
<div class="container my-5 text-center">
  <!-- Botões para abrir os modais -->
  <button
    type="button"
    class="btn btn-success"
    data-bs-toggle="modal"
    data-bs-target="#confirmModal"
  >
    Confirmar (Verde)
  </button>
  <button
    type="button"
    class="btn btn-warning"
    data-bs-toggle="modal"
    data-bs-target="#riskModal"
  >
    Risco (Laranja)
  </button>
  <button
    type="button"
    class="btn btn-danger"
    data-bs-toggle="modal"
    data-bs-target="#dangerModal"
  >
    Perigo (Vermelho)
  </button>
</div>

<!-- Modal Verde (Confirmação) -->
<div
  class="modal fade"
  id="confirmModal"
  tabindex="-1"
  aria-labelledby="confirmModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <p class="modal-title text-white" id="confirmModalLabel">Confirmação</p>
        <button
          type="button bg-white"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">Deseja confirmar esta ação?</div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="btn btn-success">Confirmar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Laranja (Áreas de Risco) -->
<div
  class="modal fade"
  id="riskModal"
  tabindex="-1"
  aria-labelledby="riskModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <p class="text-white modal-title" id="riskModalLabel">Aviso de Risco</p>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        Você está prestes a acessar uma área de risco. Tem certeza?
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="btn btn-warning">Continuar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Vermelho (Perigo) -->
<div
  class="modal fade"
  id="dangerModal"
  tabindex="-1"
  aria-labelledby="dangerModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <p class="text-white modal-title" id="dangerModalLabel">
          Aviso de Perigo
        </p>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        Atenção! Esta ação pode causar danos irreversíveis.
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="btn btn-danger">Prosseguir</button>
      </div>
    </div>
  </div>
</div>
```
