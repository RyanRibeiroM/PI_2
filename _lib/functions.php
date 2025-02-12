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

function formatarDataHora($timestamp)
{
  $dataAtual = new DateTime();
  $dataMensagem = new DateTime($timestamp);

  if ($dataAtual->format('Y-m-d') == $dataMensagem->format('Y-m-d')) {
    return $dataMensagem->format('H:i');
  } else {
    return $dataMensagem->format('d/m/Y H:i');
  }
}

function redimensionarImagem($imagemTmp, $caminhoImagem, $largura, $altura)
{
  list($larguraOriginal, $alturaOriginal, $tipo) = getimagesize($imagemTmp);
  $imagemRedimensionada = imagecreatetruecolor($largura, $altura);

  switch ($tipo) {
    case IMAGETYPE_JPEG:
      $imagemOrigem = imagecreatefromjpeg($imagemTmp);
      break;
    case IMAGETYPE_PNG:
      $imagemOrigem = imagecreatefrompng($imagemTmp);
      break;
    case IMAGETYPE_GIF:
      $imagemOrigem = imagecreatefromgif($imagemTmp);
      break;
    case IMAGETYPE_WEBP:
      $imagemOrigem = imagecreatefromwebp($imagemTmp);
      break;
    default:
      throw new Exception("Tipo de imagem não suportado.");
  }

  imagecopyresampled($imagemRedimensionada, $imagemOrigem, 0, 0, 0, 0, $largura, $altura, $larguraOriginal, $alturaOriginal);

  switch ($tipo) {
    case IMAGETYPE_JPEG:
      imagejpeg($imagemRedimensionada, $caminhoImagem, 90);
      break;
    case IMAGETYPE_PNG:
      imagepng($imagemRedimensionada, $caminhoImagem);
      break;
    case IMAGETYPE_GIF:
      imagegif($imagemRedimensionada, $caminhoImagem);
      break;
    case IMAGETYPE_WEBP:
      imagewebp($imagemRedimensionada, $caminhoImagem);
      break;
  }

  imagedestroy($imagemRedimensionada);
  imagedestroy($imagemOrigem);
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

function validarCNPJ($cnpj)
{
  $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

  if (strlen($cnpj) != 14) {
    return false;
  }

  if (preg_match('/(\d)\1{13}/', $cnpj)) {
    return false;
  }

  $tamanho = strlen($cnpj) - 2;
  $numeros = substr($cnpj, 0, $tamanho);
  $digitos = substr($cnpj, $tamanho);
  $soma = 0;
  $pos = $tamanho - 7;

  for ($i = $tamanho; $i >= 1; $i--) {
    $soma += $numeros[$tamanho - $i] * $pos--;
    if ($pos < 2) {
      $pos = 9;
    }
  }

  $resultado = $soma % 11 < 2 ? 0 : 11 - $soma % 11;
  if ($resultado != $digitos[0]) {
    return false;
  }

  $tamanho = $tamanho + 1;
  $numeros = substr($cnpj, 0, $tamanho);
  $soma = 0;
  $pos = $tamanho - 7;

  for ($i = $tamanho; $i >= 1; $i--) {
    $soma += $numeros[$tamanho - $i] * $pos--;
    if ($pos < 2) {
      $pos = 9;
    }
  }

  $resultado = $soma % 11 < 2 ? 0 : 11 - $soma % 11;
  if ($resultado != $digitos[1]) {
    return false;
  }

  return true;
}
