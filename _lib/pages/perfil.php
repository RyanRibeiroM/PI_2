<?php

$buscarInformacoesUsuario = $conn->prepare('SELECT email, nome, sobrenome, telefone, imagemPerfil FROM usuarios WHERE id = ?');
$buscarInformacoesUsuario->bind_param("i", $_SESSION['idUsuario']);
$buscarInformacoesUsuario->execute();
$resultados = $buscarInformacoesUsuario->get_result();
$informacoesUsuario = $resultados->fetch_assoc();
$buscarInformacoesUsuario->close();

//EDIÇÃO DE PERFIL
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn-editarPerfil'])) {
  $imagemValida = true;
  $imagemEnviada = false;
  $telefoneEnviado = false;
  if (!empty($_FILES['imagem']['name'])) {
    $imagem = basename($_FILES['imagem']['name']);
    $imagemTmp = $_FILES['imagem']['tmp_name'];
    $extensaoImagem = strtolower(pathinfo($imagem, PATHINFO_EXTENSION));
    $imagem = str_replace(' ', '', basename($_FILES['imagem']['name']));
    $extensoesPermitidas = array("jpeg", "jpg", "png", "gif", "webp");
    $imagemEnviada = true;
    if (!verificaPixel($imagemTmp) || !in_array($extensaoImagem, $extensoesPermitidas) || $_FILES['imagem']['size'] > 3145728) {
      $imagemValida = false;
    }
  }

  if ($imagemValida) {
    if ($_POST['nomeCompleto'] != "") {
      $nomeCompleto = $_POST['nomeCompleto'];
      $telefone = $_POST['telefone'];
      if ($telefone != "") {
        $telefoneEnviado = true;
      }

      $nome = separarNome($nomeCompleto);

      if (verificarNomeCompleto($nomeCompleto)) {
        if (verificarTelefone($telefone) || $telefoneEnviado == false) {
          if ($imagemEnviada) {
            $caminhoImagem = 'assets/images/usuarios/' . $_SESSION['idUsuario'] . '/';
            if (!file_exists($caminhoImagem)) {
              mkdir($caminhoImagem, 0777, true);
            }
            $caminhoImagem = $caminhoImagem . $imagem;
            move_uploaded_file($imagemTmp, $caminhoImagem);
          }
          $dados = [
            'nome' => $nome['nome'],
            'sobrenome' => $nome['sobrenome'],
            'dataModificacao' => $dataHojeHora
          ];
          $parametros = 'sss';

          ($telefoneEnviado ? ($dados['telefone'] = $telefone) && ($parametros = $parametros . 's') : '');
          ($imagemEnviada ? ($dados['imagemPerfil'] = $caminhoImagem) && ($parametros = $parametros . 's') : '');

          update('usuarios', $dados, 'id = ' . $_SESSION['idUsuario'], $parametros);

          header("Location: /perfil/");
        } else {
          // AVISO TELEFONE
          $_SESSION['mensagemEditarPerfil'] = '<div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon><div>';
          $_SESSION['mensagemEditarPerfil'] .= 'Ops, Algo de errado!';
          $_SESSION['mensagemEditarPerfil'] .= '<p class="fw-medium text-danger-600 text-sm mt-8">';
          $_SESSION['mensagemEditarPerfil'] .= 'Telefone inválido, tente inserir um telefone no formato de (XX) XXXXX-XXXX';
          $_SESSION['mensagemEditarPerfil'] .= '</p></div></div><button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-iconicon="iconamoon:sign-times-light" class="icon"></iconify-iconicon=></button></div></div>';
          header("Location: /perfil/");
        }
      } else {
        // AVISO NOME COMPLETO 
        $_SESSION['mensagemEditarPerfil'] = '<div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon><div>';
        $_SESSION['mensagemEditarPerfil'] .= 'Ops, Algo de errado!';
        $_SESSION['mensagemEditarPerfil'] .= '<p class="fw-medium text-danger-600 text-sm mt-8">';
        $_SESSION['mensagemEditarPerfil'] .= 'Nome Completo inválido, tente inserir um nome composto <br> Exemplo: João Martins';
        $_SESSION['mensagemEditarPerfil'] .= '</p></div></div><button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-iconicon="iconamoon:sign-times-light" class="icon"></iconify-iconicon=></button></div></div>';
        header("Location: /perfil/");
      }
    } else {
      //AVISO PARA DADOS OBRIGATORIOS NÃO RECEBIDOS 
      $_SESSION['mensagemEditarPerfil'] = '<div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon><div>';
      $_SESSION['mensagemEditarPerfil'] .= 'Ops, Algo de errado!';
      $_SESSION['mensagemEditarPerfil'] .= '<p class="fw-medium text-danger-600 text-sm mt-8">';
      $_SESSION['mensagemEditarPerfil'] .= 'Campos Vazios, insira todas as informações';
      $_SESSION['mensagemEditarPerfil'] .= '</p></div></div><button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-iconicon="iconamoon:sign-times-light" class="icon"></iconify-iconicon=></button></div></div>';
      header("Location: /perfil/");
    }
  } else {
    // AVISO PARA A IMAGEM NÃO QUADRADA
    $_SESSION['mensagemEditarPerfil'] = '<div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon><div>';
    $_SESSION['mensagemEditarPerfil'] .= 'Ops, Algo de errado!';
    $_SESSION['mensagemEditarPerfil'] .= '<p class="fw-medium text-danger-600 text-sm mt-8">';
    $_SESSION['mensagemEditarPerfil'] .= 'Imagem Inválida.<br>A imagem deve ter largura e altura igual, ter no máximo 3MB de tamanho e ser um formato suportado (.jpeg, .jpg, .png, .gif, .webp)';
    $_SESSION['mensagemEditarPerfil'] .= '</p></div></div><button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-iconicon="iconamoon:sign-times-light" class="icon"></iconify-iconicon=></button></div></div>';
    header("Location: /perfil/");
  }
}

//EDIÇÃO DE SENHA
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn-editarSenha'])) {
  if ($_POST['senha'] != "" && $_POST['confirmar-senha'] != "") {
    $senha = $_POST['senha'];
    $confirmarSenha = $_POST['confirmar-senha'];

    if (compararSenha($senha, $confirmarSenha)) {
      if (verificarSenha($senha)) {
        $senha = password_hash($senha, PASSWORD_BCRYPT);
        $dados = [
          'senha' => $senha
        ];
        update('usuarios', $dados, 'id = ' . $_SESSION['idUsuario'], 's');
        $_SESSION['mensagemEditarPerfil'] = '<div class="alert alert-success bg-success-100 text-success-600 border-success-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="bi:patch-check" class="icon text-xl mt-4 flex-shrink-0"></iconify-icon><div>Senha alterada com sucesso!<p class="fw-medium text-success-600 text-sm mt-8">A partir de agora você deve usar essa senha para fazer acesso ao sistema!</p></div></div><button class="remove-button text-success-600 text-xxl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button></div></div>';
        header("Location: /perfil/");
      } else {
        $_SESSION['mensagemEditarPerfil'] = '<div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon><div>';
        $_SESSION['mensagemEditarPerfil'] .= 'Ops, Algo de errado!';
        $_SESSION['mensagemEditarPerfil'] .= '<p class="fw-medium text-danger-600 text-sm mt-8">';
        $_SESSION['mensagemEditarPerfil'] .= 'senha inválida, ela precisa ter no mínimo 8 caracteres sendo eles letras minusculas e maisculas alem de números e caracteres especiais';
        $_SESSION['mensagemEditarPerfil'] .= '</p></div></div><button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-iconicon="iconamoon:sign-times-light" class="icon"></iconify-iconicon=></button></div></div>';
        header("Location: /perfil/");
      }
    } else {
      $_SESSION['mensagemEditarPerfil'] = '<div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon><div>';
      $_SESSION['mensagemEditarPerfil'] .= 'Ops, Algo de errado!';
      $_SESSION['mensagemEditarPerfil'] .= '<p class="fw-medium text-danger-600 text-sm mt-8">';
      $_SESSION['mensagemEditarPerfil'] .= 'A senhas não são iguais';
      $_SESSION['mensagemEditarPerfil'] .= '</p></div></div><button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-iconicon="iconamoon:sign-times-light" class="icon"></iconify-iconicon=></button></div></div>';
      header("Location: /perfil/");
    }
  }
}
