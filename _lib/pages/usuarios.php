<?php
if (empty($sub_page)) {
    $quant_por_pagina = isset($_GET['quant_pg']) ? intval($_GET['quant_pg']) : 15;

    $pg_atual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;

    $calc_pg = ($pg_atual - 1) * $quant_por_pagina;

    $registros_total = $conn->prepare("SELECT COUNT(*) AS total FROM usuarios");
    $registros_total->execute();
    $total = $registros_total->get_result();
    $total = $total->fetch_assoc();
    $registros = $total['total'];

    $total_pg = ceil($registros / $quant_por_pagina);

    $usuarios = $conn->prepare("SELECT id, email, nome, sobrenome, dataCadastro, imagemPerfil, nivel, ativo, startup  FROM usuarios LIMIT ?, ?");
    $usuarios->bind_param("ii", $calc_pg, $quant_por_pagina);
    $usuarios->execute();
    $resultados = $usuarios->get_result();

    $usuarios = [];
    while ($row = $resultados->fetch_assoc()) {
        $usuarios[] = $row;
    }

    $max_links = 5;
    $start = max(1, $pg_atual - floor($max_links / 2));
    $end = min($total_pg, $pg_atual + floor($max_links / 2));

    if ($start > $total_pg - $max_links + 1) {
        $start = max(1, $total_pg - $max_links + 1);
        $end = $total_pg;
    } else {
        $end = min($max_links, $total_pg);
    }
}

if (!empty($sub_pagina) && $sub_pagina === "cadastrar") {
    $buscarStartups = $conn->prepare("SELECT id, nome FROM startups WHERE id != 1");
    $buscarStartups->execute();
    $resultados = $buscarStartups->get_result();
    $startups = [];

    while ($row = $resultados->fetch_assoc()) {
        $startups[] = $row;
    }

    if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["cadastrarUsuario"])) {
        try {
            if (empty($_POST['nome']) || empty($_POST['email']) || empty($_POST['cargo']) || empty($_POST['senha']) || empty($_POST['confirmarSenha'])) {
                throw new Exception("Todos os campos devem ser preenchidos!");
            }

            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $telefone = $_POST['telefone'];
            $cargo = $_POST['cargo'];
            $senha = $_POST['senha'];
            $confirmarSenha = $_POST['confirmarSenha'];

            if (!verificarNomeCompleto($nome)) {
                throw new Exception("Nome Completo Inválido, Por favor insira o nome composto. (EX: joão da Silva)");
            }

            $nome = separarNome($nome);

            if (!verificarEmail($email)) {
                throw new Exception("Email Inválido!");
            }

            if (!empty($_POST['telefone']) && !verificarTelefone($telefone)) {
                throw new Exception("Telefone Inválido!");
            }


            if (!compararSenha($senha, $confirmarSenha)) {
                throw new Exception("As senhas digitadas não são iguais!");
            }

            if (!verificarSenha($senha)) {
                throw new Exception("Senhas não é forte, por favor insira um senha que tenha 8 caracteres entre letras minúsculas, maiúsculas, números e caracteres especiais!");
            }

            if ($_POST['cargo'] != 'membrostartup' && $_POST['cargo'] != 'equipestartufc') {
                throw new Exception("Cargo Inválido!");
            }

            if ($_POST['cargo'] == 'equipestartufc' && !empty($_POST['startups'])) {
                throw new Exception("Apenas membros de startUP podem selecionar o campo de startUP!");
            }

            if ($_POST['cargo'] == 'membrostartup' && empty($_POST['startups'])) {
                throw new Exception("Selecione a Startup que o usuário pertence");
            }

            $ativo = 3; // usuario desativado
            $buscar_semelhantes = $conn->prepare("SELECT * FROM usuarios WHERE email = ? OR telefone = ?  OR nome = ? OR sobrenome = ? AND ativo != ? ");
            $buscar_semelhantes->bind_param("ssssi", $email, $telefone, $nome['nome'], $nome['sobrenome'], $ativo);
            $buscar_semelhantes->execute();
            $resultados = $buscar_semelhantes->get_result();

            if ($resultados->num_rows > 0) {
                $semelhante = $resultados->fetch_assoc();

                if (strtolower($semelhante['nome']) === strtolower($nome['nome']) && strtolower($semelhante['sobrenome']) == strtolower($nome['sobrenome'])) {
                    throw new Exception("Já existe um usuário cadastrado com esse nome!");
                }

                if ($semelhante['email'] == $email) {
                    throw new Exception("Já existe um usuário cadastrado com esse email!");
                }

                if ($semelhante['telefone'] == $telefone) {
                    throw new Exception("Já existe um usuário cadastrado com esse telefone!");
                }
            }

            $nivel_usuario = ($_POST['cargo'] == 'membrostartup') ? 1 : 3;

            if ($_POST['cargo'] == "membrostartup") {
                $id_startup = ($_POST['startups'] == 'naocadastrado') ? 0 : intval($_POST['startups']);
            } else {
                $id_startup = 1; // equipe da startufc
            }

            $senha = password_hash($senha, PASSWORD_BCRYPT);

            $dados = [
                "email" => $email,
                "senha" => $senha,
                "nome" => $nome['nome'],
                "sobrenome" => $nome['sobrenome'],
                "telefone" => $telefone,
                "imagemPerfil" => 'assets/images/usuarioPadrao.webp',
                "nivel" => $nivel_usuario,
                "startup" => $id_startup
            ];

            insert("usuarios", $dados, "ssssssii");

            $mensagem_cadastro_usuario = '<div class="alert alert-success bg-success-100 text-success-600 border-success-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert">';
            $mensagem_cadastro_usuario .= '<div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2">';
            $mensagem_cadastro_usuario .= '<iconify-icon icon="bi:patch-check" class="icon text-xl mt-4 flex-shrink-0"></iconify-icon><div>';
            $mensagem_cadastro_usuario .= 'Usuário cadastrado com sucesso!';
            $mensagem_cadastro_usuario .= '<p class="fw-medium text-success-600 text-sm mt-8">Repasse o acesso !</p>';
            $mensagem_cadastro_usuario .= '</div></div><button class="remove-button text-success-600 text-xxl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button></div></div>';
        } catch (Exception $e) {
            $mensagem_cadastro_usuario = '<div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon><div>';
            $mensagem_cadastro_usuario .= 'Ops, Algo de errado!';
            $mensagem_cadastro_usuario .= '<p class="fw-medium text-danger-600 text-sm mt-8">';
            $mensagem_cadastro_usuario .= htmlspecialchars($e->getMessage());
            $mensagem_cadastro_usuario .= '</p></div></div><button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button></div></div>';
        }
    }
}

if (!empty($sub_pagina) && $sub_pagina === "adicionar-aviso") {
    $buscarStartups = $conn->prepare("SELECT id, nome FROM startups");
    $buscarStartups->execute();
    $resultados = $buscarStartups->get_result();
    $startups = [];

    while ($row = $resultados->fetch_assoc()) {
        $startups[] = $row;
    }
}

if (!empty($sub_pagina) && $sub_pagina === "detalhes") {
    $id_usuario = (isset($_GET['id_usuario']) ? $_GET['id_usuario'] : "");

    if (!empty($id_usuario)) {
        $buscarUsuario = $conn->prepare('SELECT id, email, nome, sobrenome, telefone, imagemPerfil, startup FROM usuarios WHERE id = ?');
        $buscarUsuario->bind_param('i', $id_usuario);
        $buscarUsuario->execute();
        $resultado = $buscarUsuario->get_result();
        $detalhesUsuario = $resultado->fetch_assoc();
        $buscarUsuario->close();

        $buscarStartups = $conn->prepare('SELECT id, nome FROM startups WHERE id != 1');
        $buscarStartups->execute();
        $resultados = $buscarStartups->get_result();

        $startups = [];
        while ($row = $resultados->fetch_assoc()) {
            $startups[] = $row;
        }
    }
}
