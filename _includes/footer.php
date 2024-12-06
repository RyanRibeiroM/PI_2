<?php if ($pagina !== "login") { ?>
  <footer class="d-footer">
    <div class="row align-items-center justify-content-between">
      <div class="col-auto">
        <p class="mb-0">© 2024 startUFC. Todos os direitos resevados.</p>
      </div>
      <div class="col-auto">
        <p class="mb-0">Feito por<span class="text-primary-600">&nbsp;Rian Ribeiro & Tiago Filho & Fernanda Vasconcelos</span></p>
      </div>
    </div>
  </footer>
<?php } ?>
</main>

<?php if ($pagina === 'mural') {
  include('_modulos/mural/janelas.php');
} ?>

<script src="assets/js/lib/jquery-3.7.1.min.js"></script>
<script src="assets/js/lib/bootstrap.bundle.min.js"></script>
<script src="assets/js/lib/apexcharts.min.js"></script>
<script src="assets/js/lib/dataTables.min.js"></script>
<script src="assets/js/lib/iconify-icon.min.js"></script>
<script src="assets/js/lib/jquery-ui.min.js"></script>
<script src="assets/js/lib/jquery-jvectormap-2.0.5.min.js"></script>
<script src="assets/js/lib/jquery-jvectormap-world-mill-en.js"></script>
<script src="assets/js/lib/magnifc-popup.min.js"></script>
<script src="assets/js/lib/slick.min.js"></script>
<script src="assets/js/app.js"></script>
<script src="assets/js/homeOneChart.js"></script>

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
  }
  if (!empty($sub_pagina) & $sub_pagina === 'detalhes') { ?>
    <script>
      var imagemUsuario = '<?= $detalhesUsuario['imagemPerfil'] ?>';
    </script>
    <script src="_modulos/perfil/perfil.js"></script>
<?php }
}
?>

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