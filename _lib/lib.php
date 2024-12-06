<?php
set_include_path(get_include_path() . PATH_SEPARATOR . '/home/u890647006/domains/rywe.com.br/public_html/startufc/_credenciais/');
require_once('config.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_only_cookies', 1);

session_start();

if (empty($_SESSION["token"])) {
  $_SESSION["token"] = bin2hex(random_bytes(32));
}

include('functions.php');

date_default_timezone_set('America/Sao_Paulo');
$baseUrl = "https://startufc.rywe.com.br/";
$caminhoAbsolutoSite = $_SERVER['DOCUMENT_ROOT'] . "/";
$nomeProjeto = "startUFC";
$dataHoje = date('Y-m-d');
$dataHojeHora = date('Y-m-d H:i:s');
$pagina = $_GET["page"] ?? "";
$sub_pagina = $_GET["sub_page"] ?? "";

//IMAGEM DO USUÁRIO
if (isset($_SESSION['idUsuario']) && !empty($_SESSION['idUsuario'])) {
  $buscarImagemPerfil = $conn->prepare('SELECT imagemPerfil FROM usuarios WHERE id = ?');
  $buscarImagemPerfil->bind_param("i", $_SESSION['idUsuario']);
  $buscarImagemPerfil->execute();
  $resultados = $buscarImagemPerfil->get_result();
  $imagemPerfil = $resultados->fetch_assoc();
  $buscarImagemPerfil->close();
}

$acessoComum = ['1', '2', '3'];
$acessoStartup = ['1', '2'];
$acessoEspecial = ['2', '3'];
$acessoMembro = ['1'];
$acessoResponsavel = ['2'];
$acessoAdmin = ['3'];

checkLogin($pagina);

include('_lib/pages/usuarioLogado.php');

if ($pagina == 'home') {
  $nomeProjeto = $nomeProjeto . " | home";
  ob_start();
  include('_pages/inicial.php');
  $conteudoPg = ob_get_clean();
}

if (empty($pagina)) {
  $nomeProjeto = $nomeProjeto . " | home";
  ob_start();
  include('_pages/inicial.php');
  $conteudoPg = ob_get_clean();
}

if ($pagina == 'perfil') {
  $titulopg = $nomeProjeto . "| perfil";
  ob_start();
  include('_lib/pages/perfil.php');
  include('_pages/perfil.php');
  $conteudoPg = ob_get_clean();
}
if ($pagina == 'login') {
  $titulopg = $nomeProjeto . "| login";
  ob_start();
  include("_lib/pages/login.php");
  include('_pages/login.php');
  $conteudoPg = ob_get_clean();
}

if ($pagina === "startups") {
  $smt_title = "Startups | " . $nomeProjeto;

  include("_lib/pages/startups.php");

  if (!empty($sub_pagina) && $sub_pagina === "cadastrar") {
    if (verificaAcesso($usuarioLogado['nivel'], $acessoAdmin)) {
      ob_start();
      include("_modulos/startups/cadastro.php");
      $conteudoPg = ob_get_clean();
    } else {
      header('Location: /esta-pagina-nao-existe/');
    }
  }

  if (!empty($sub_pagina) && $sub_pagina === "minhastartup") {
    if (verificaAcesso($usuarioLogado['nivel'], $acessoStartup)) {
      ob_start();
      include("_modulos/startups/minhastartup.php");
      $conteudoPg = ob_get_clean();
    } else {
      header('Location: /esta-pagina-nao-existe/');
    }
  }

  if (!empty($sub_pagina) && $sub_pagina === "adicionar-aviso") {
    if (verificaAcesso($usuarioLogado['nivel'], $acessoEspecial)) {
      ob_start();
      include("_modulos/startups/aviso.php");
      $conteudoPg = ob_get_clean();
    } else {
      header('Location: /esta-pagina-nao-existe/');
    }
  }

  if (!empty($sub_pagina) && $sub_pagina === "falarcomresponsavel") {
    if (verificaAcesso($usuarioLogado['nivel'], $acessoMembro)) {
      ob_start();
      include("_modulos/startups/falarcomresponsavel.php");
      $conteudoPg = ob_get_clean();
    } else {
      header('Location: /esta-pagina-nao-existe/');
    }
  }

  if (empty($sub_pagina)) {
    if (verificaAcesso($usuarioLogado['nivel'], $acessoEspecial)) {
      ob_start();
      include("_pages/startups.php");
      $conteudoPg = ob_get_clean();
    } else {
      header('Location: /esta-pagina-nao-existe/');
    }
  }
}

if ($pagina === "usuarios") {

  if (verificaAcesso($usuarioLogado['nivel'], $acessoAdmin)) {
    $smt_title = "Usuários | " . $nomeProjeto;

    include("_lib/pages/usuarios.php");

    if (!empty($sub_pagina) && $sub_pagina === "cadastrar") {
      ob_start();
      include("_modulos/usuarios/cadastro.php");
      $conteudoPg = ob_get_clean();
    }

    if (!empty($sub_pagina) && $sub_pagina === "detalhes") {
      ob_start();
      include("_modulos/usuarios/detalhes.php");
      $conteudoPg = ob_get_clean();
    }

    if (empty($sub_pagina)) {
      ob_start();
      include("_pages/usuarios.php");
      $conteudoPg = ob_get_clean();
    }
  } else {
    header('Location: /esta-pagina-nao-existe/');
  }
}

if ($pagina === "mural") {

  if (verificaAcesso($usuarioLogado['nivel'], $acessoAdmin)) {
    $smt_title = "Mural | " . $nomeProjeto;
    include("_lib/pages/mural.php");

    if (!empty($sub_pagina) && $sub_pagina === "cadastrar") {
      ob_start();
      include("_modulos/mural/cadastro.php");
      $conteudoPg = ob_get_clean();
    }

    if (empty($sub_pagina)) {
      ob_start();
      include("_pages/mural.php");
      $conteudoPg = ob_get_clean();
    }
  } else {
    header('Location: /esta-pagina-nao-existe/');
  }
}

if ($pagina === "forum") {
  $smt_title = "forum | " . $nomeProjeto;
  include("_lib/pages/forum.php");

  if (!empty($sub_pagina) && $sub_pagina === "cadastrar") {
    if (verificaAcesso($usuarioLogado['nivel'], $acessoAdmin)) {
      ob_start();
      include("_modulos/forum/cadastro.php");
      $conteudoPg = ob_get_clean();
    } else {
      header('Location: /esta-pagina-nao-existe/');
    }
  }

  if (empty($sub_pagina)) {
    ob_start();
    include("_pages/forum.php");
    $conteudoPg = ob_get_clean();
  }
}

if ($pagina === '404') {
  $smt_title = "404 | " . $nomeProjeto;
  ob_start();
  include("_pages/404.php");
  $conteudoPg = ob_get_clean();
}

if ($pagina === 'sair') {
  session_unset();
  session_destroy();
  header("Location: /login");
}
