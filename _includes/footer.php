<?php if ($pagina !== "login") { ?>
  <footer class="d-footer">
    <div class="row align-items-center justify-content-between">
      <div class="col-auto">
        <p class="mb-0">© 2025 startUFC. Todos os direitos reservados.</p>
      </div>
      <div class="col-auto">
        <p class="mb-0">Feito por<span class="text-primary-600">&nbsp;Rian Ribeiro & Tiago Filho & Fernanda Vasconcelos</span></p>
      </div>
    </div>
  </footer>
<?php } ?>
</main>



<script src="assets/js/lib/jquery-3.7.1.min.js"></script>
<script src="assets/js/lib/bootstrap.bundle.min.js"></script>
<!-- <script src="assets/js/lib/apexcharts.min.js"></script> -->
<script src="assets/js/lib/dataTables.min.js"></script>
<script src="assets/js/lib/iconify-icon.min.js"></script>
<script src="assets/js/lib/jquery-ui.min.js"></script>
<script src="assets/js/lib/jquery-jvectormap-2.0.5.min.js"></script>
<script src="assets/js/lib/jquery-jvectormap-world-mill-en.js"></script>
<script src="assets/js/lib/magnifc-popup.min.js"></script>
<script src="assets/js/lib/slick.min.js"></script>
<script src="assets/js/app.js"></script>
<!-- <script src="assets/js/homeOneChart.js"></script> -->

<?php if ($pagina === 'mural') {
  include('_modulos/mural/janelas.php');
} ?>

<?php if ($pagina === 'mural') { ?>
  <script src="_modulos/caixa/caixa.js"></script>
<?php } ?>


<?php if ($pagina === 'perfil') { ?>
  <script>
    var imagemUsuario = '<?= $usuarioLogado['imagemPerfil'] ?>';
  </script>
  <script src="_modulos/perfil/perfil.js"></script>
<?php }
?>

<?php if ($pagina === 'usuarios') {
  if (empty($sub_pagina)) {
    include('_modulos/usuarios/janelas.php');
    echo '<script src="_modulos/usuarios/usuarios.js"></script>';
  }
  if (!empty($sub_pagina) & $sub_pagina === 'detalhes') { ?>
    <script>
      var imagemUsuario = '<?= $detalhesUsuario['imagemPerfil'] ?>';
    </script>
    <script src="_modulos/perfil/perfil.js"></script>
<?php }
}
?>
<?php if ($pagina === 'startups') {
  if (empty($sub_pagina)) {
    include('_modulos/startups/janelas.php');
  }
  if (!empty($sub_pagina) & $sub_pagina === 'cadastrar') {
    echo '<script src="_modulos/perfil/perfil.js"></script>';
  }
  if (!empty($sub_pagina) & $sub_pagina === 'minhastartup') {
    include('_modulos/startups/janelas.php');
    echo '<script src="_modulos/perfil/perfil.js"></script>';
  }
  if (!empty($sub_pagina) & $sub_pagina === 'adicionar-aviso') {
    echo '<script src="_modulos/startups/aviso.js"></script>';
  }
} ?>

<?php if ($pagina === 'mural') {
  if (!empty($sub_pagina) & $sub_pagina === 'cadastrar') { ?>
    <script src="_modulos/mural/mural.js"></script>
<?php }
}
?>

<?php if ($pagina === 'caixa-de-entrada') {
  include('_modulos/caixa/janelas.php');
} ?>

<?php if ($pagina === 'forum') { ?>

  <?php if (empty($sub_pagina) && $sub_pagina != 'cadastrar') {
    include('_modulos/forum/janelas.php');
  ?>
    <script src="_modulos/forum/atualizar_lista.js"></script>
  <?php } ?>

  <?php if (!empty($id_forum)) { ?>
    <script src="_modulos/forum/buscar_mensagens.js?t=<?= time() ?>"></script>
    <script src="_modulos/forum/enviar_mensagem.js?t=<?= time() ?>"></script>
  <?php } ?>

  <?php if (!empty($sub_pagina) && $sub_pagina === 'cadastrar') { ?>
    <script src="_modulos/forum/cadastro.js"></script>
  <?php } ?>

<?php } ?>

<?php if (empty($pagina) || $pagina === 'mural' || $pagina === 'home') { ?>
  <script src="assets/js/carrosel.js"></script>
<?php }
?>

<script>
  // ================== Password Show Hide Js Start ==========
  function initializePasswordToggle(toggleSelector) {
    $(toggleSelector).on('click', function() {
      $(this).toggleClass("ri-eye-off-line");
      var input = $($(this).attr("data-toggle"));
      if (input.attr("type") === "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });
  }
  // Call the function
  initializePasswordToggle('.toggle-password');
  // ========================= Password Show Hide Js End ===========================
</script>

</body>

</html>