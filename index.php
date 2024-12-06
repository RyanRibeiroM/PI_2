<?php
  include('_lib/lib.php');
  include("_includes/head.php");

  if($pagina !== "login" && $pagina !=="404"){
    include("_includes/header.php");
  }
  
  include("_includes/page.php");
  include("_includes/footer.php");
?>