<?php

function checkLogin($pagina)
{
  if ($pagina === "login") {
    if (isset($_SESSION['idUsuario']) || !empty($_SESSION['idUsuario'])) {
      header("Location: /home");
      exit();
    }
  }

  if ($pagina !== "login" && $pagina !== "404") {
    if (!isset($_SESSION['idUsuario']) || empty($_SESSION['idUsuario'])) {
      header("Location: /login");
      exit();
    }
  }
}

function verificarNomeCompleto($nome)
{
  $nome = trim($nome);

  $nomeCompleto = explode(' ', $nome);

  if (count($nomeCompleto) < 2) {
    return false;
  }

  if (strlen($nomeCompleto[0]) < 2) {
    return false;
  }

  if (strlen($nomeCompleto[1]) < 2) {
    return false;
  }

  return true;
}
function verificarTelefone($telefone)
{
  if (preg_match('/^[0-9\(\)\-\s]+$/', $telefone)) {
    $telefone = preg_replace('/[^0-9]/', '', $telefone);
    if (strlen($telefone) == 10 || strlen($telefone) == 11) {
      return true;
    } else {
      return false;
    }
  } else {
    return false;
  }
}
function verificarUsuario($usuario)
{
  if (preg_match('/^[a-z0-9\._-]{1,20}$/', $usuario)) {
    return true;
  } else {
    return false;
  }
}

function verificarEmail($email)
{
  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return true;
  } else {
    return false;
  }
}

function verificarSenha($senha)
{
  if (strlen($senha) < 8) {
    return false;
  }

  if (!preg_match('/[a-z]/', $senha)) {
    return false;
  }
  if (!preg_match('/[A-Z]/', $senha)) {
    return false;
  }
  if (!preg_match('/[0-9]/', $senha)) {
    return false;
  }
  if (!preg_match('/[\W_]/', $senha)) {
    return false;
  }

  return true;
}

function compararSenha($senha1, $senha2)
{
  if ($senha1 === $senha2) {
    return true;
  } else {
    return false;
  }
}

function separarNome($nome)
{
  $partes = explode(" ", $nome);
  $nome = array_shift($partes);
  $sobrenome = implode(" ", $partes);

  return [
    'nome' => $nome,
    'sobrenome' => $sobrenome
  ];
}

function insert($tabela, $dados, $tiposParametros)
{
  global $conn;

  $campos = implode(", ", array_keys($dados));
  $valores = implode(", ", array_fill(0, count($dados), '?'));

  $sql = $conn->prepare("INSERT INTO $tabela ($campos) VALUES ($valores)");
  $sql->bind_param($tiposParametros, ...array_values($dados));
  $sql->execute();
  $sql->close();
}

function update($tabela, $dados, $condicao, $tiposParametros)
{
  global $conn;

  $campos = implode(" = ?, ", array_keys($dados)) . " = ?";
  $sql = $conn->prepare("UPDATE $tabela SET $campos WHERE $condicao");
  $sql->bind_param($tiposParametros, ...array_values($dados));
  $sql->execute();
  $sql->close();
}

function verificaPixel($imagem)
{
  list($largura, $altura) = getimagesize($imagem);
  if ($largura == $altura) {
    return true;
  } else {
    return false;
  }
}

function verificaAcesso($nivelUsuario, $nivelPermitidos)
{
  if (!in_array($nivelUsuario, $nivelPermitidos)) {
    return false;
  }
  return true;
}

function urlAmigavel($texto)
{
  $texto = mb_strtolower($texto, 'UTF-8');

  $texto = preg_replace(
    array(
      '/[áàâãäå]/u',
      '/[ÁÀÂÃÄÅ]/u',
      '/[éèêë]/u',
      '/[ÉÈÊË]/u',
      '/[íìîï]/u',
      '/[ÍÌÎÏ]/u',
      '/[óòôõö]/u',
      '/[ÓÒÔÕÖ]/u',
      '/[úùûü]/u',
      '/[ÚÙÛÜ]/u',
      '/[ñ]/u',
      '/[Ñ]/u',
      '/[ç]/u',
      '/[Ç]/u'
    ),
    array(
      'a',
      'a',
      'e',
      'e',
      'i',
      'i',
      'o',
      'o',
      'u',
      'u',
      'n',
      'n',
      'c',
      'c'
    ),
    $texto
  );

  $texto = preg_replace('/[^a-z0-9\s]u/', '', $texto);

  $texto = str_replace('.', '', $texto);

  $texto = preg_replace('/\s+/u', '-', $texto);

  return $texto;
}
