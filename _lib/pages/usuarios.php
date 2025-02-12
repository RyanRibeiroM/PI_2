<?php
if (empty($sub_pagina)) {
    $quant_por_pagina = isset($_GET['quant_pg']) ? intval($_GET['quant_pg']) : 15;

    $pg_atual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;

    $calc_pg = ($pg_atual - 1) * $quant_por_pagina;

    $complemento_url = "";
    $clausa = "";

    $complementosPermitidosAtivo = [
        "ativos" => 1,
        "inativos" => 2,
        "deletados" => 3,
    ];

    $complementosPermitidosNivel = [
        "membros" => 1,
        "responsaveis" => 2,
        "startufc" => 4
    ];

    if (!empty($complemento) && array_key_exists($complemento, $complementosPermitidosAtivo)) {
        $clausa = "&& u.ativo = " . $complementosPermitidosAtivo[$complemento];
        $complemento_url = $complemento . "/";
    } else if (!empty($complemento) && array_key_exists($complemento, $complementosPermitidosNivel)) {
        $clausa = "&& u.nivel = " . $complementosPermitidosNivel[$complemento];
        $complemento_url = $complemento . "/";
    } else if (!empty($complemento) && !array_key_exists($complemento, $complementosPermitidosAtivo)) {
        header("location: /esta-pagina-nao-existe/");
    }


    $registros_total = $conn->prepare("SELECT COUNT(*) AS total FROM usuarios as u WHERE u.nivel <> 3 && u.id <>  " . $_SESSION['idUsuario'] . " " . $clausa);
    $registros_total->execute();
    $total = $registros_total->get_result();
    $total = $total->fetch_assoc();
    $registros = $total['total'];

    $total_pg = ceil($registros / $quant_por_pagina);

    $usuarios = $conn->prepare("SELECT u.id, u.email, u.nome, u.sobrenome, u.dataCadastro, u.imagemPerfil, u.nivel, u.ativo, u.startup, s.nome AS nome_startup FROM usuarios AS u LEFT JOIN startups AS s ON u.startup = s.id WHERE u.nivel <> 3 && u.id <>  " . $_SESSION['idUsuario'] . " " . $clausa . " LIMIT ?, ?");
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

    try {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["desativar_usuario"])) {
            if (empty($_POST['id_usuario']) || empty($_POST['email_usuario'])) {
                throw new Exception("Usuário Inválido, falta de informações para a ação");
            }

            $id_usuario = $_POST['id_usuario'];
            $email_usuario = $_POST['email_usuario'];

            $mudar_ativo = $conn->prepare('UPDATE usuarios SET ativo = 2 WHERE id = ? AND email = ?');
            $mudar_ativo->bind_param('is', $id_usuario, $email_usuario);
            if (!$mudar_ativo->execute()) {
                throw new Exception("Erro ao desativar o usuário: " . $mudar_ativo->error);
            }
            header('Location: /usuarios');
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["deletar_usuario"])) {
            if (empty($_POST['id_usuario']) || empty($_POST['email_usuario'])) {
                throw new Exception("Usuário Inválido, falta de informações para a ação");
            }

            $id_usuario = $_POST['id_usuario'];
            $email_usuario = $_POST['email_usuario'];

            $mudar_ativo = $conn->prepare('UPDATE usuarios SET ativo = 3 WHERE id = ? AND email = ?');
            $mudar_ativo->bind_param('is', $id_usuario, $email_usuario);
            if (!$mudar_ativo->execute()) {
                throw new Exception("Erro ao deletar o usuário: " . $mudar_ativo->error);
            }
            header('Location: /usuarios');
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["ativar_usuario"])) {
            if (empty($_POST['id_usuario']) || empty($_POST['email_usuario'])) {
                throw new Exception("Usuário Inválido, falta de informações para a ação");
            }

            $id_usuario = $_POST['id_usuario'];
            $email_usuario = $_POST['email_usuario'];

            $mudar_ativo = $conn->prepare('UPDATE usuarios SET ativo = 1 WHERE id = ? AND email = ?');
            $mudar_ativo->bind_param('is', $id_usuario, $email_usuario);
            if (!$mudar_ativo->execute()) {
                throw new Exception("Erro ao ativar o usuário: " . $mudar_ativo->error);
            }
            header('Location: /usuarios');
        }
    } catch (Exception $e) {
        $mensagem_usuario = '<div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon><div>';
        $mensagem_usuario .= 'Ops, Algo de errado!';
        $mensagem_usuario .= '<p class="fw-medium text-danger-600 text-sm mt-8">';
        $mensagem_usuario .= htmlspecialchars($e->getMessage());
        $mensagem_usuario .= '</p></div></div><button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button></div></div>';
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

            $buscar_semelhantes = $conn->prepare("SELECT * FROM usuarios WHERE email = ? OR (LOWER(nome) = LOWER(?) AND LOWER(sobrenome) = LOWER(?)) AND ativo <> 3");
            $buscar_semelhantes->bind_param("sss", $email, $nome['nome'], $nome['sobrenome']);
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
            }

            if ($telefone != '') {
                $buscar_telefone = $conn->prepare("SELECT * FROM usuarios WHERE telefone = ?");
                $buscar_telefone->bind_param("s", $telefone);
                $buscar_telefone->execute();
                $resultados = $buscar_telefone->get_result();

                if ($resultados->num_rows > 0) {
                    throw new Exception("Já existe um usuário cadastrado com esse telefone!");
                }

                $buscar_telefone->close();
            }

            $nivel_usuario = ($_POST['cargo'] == 'membrostartup') ? 1 : 4;

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
            $editar_membros = $conn->prepare("UPDATE startups SET membros = membros + 1 WHERE id = $id_startup");
            $editar_membros->execute();
            $editar_membros->close();


            header("Location: /usuarios");
        } catch (Exception $e) {
            $mensagem_cadastro_usuario = '<div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon><div>';
            $mensagem_cadastro_usuario .= 'Ops, Algo de errado!';
            $mensagem_cadastro_usuario .= '<p class="fw-medium text-danger-600 text-sm mt-8">';
            $mensagem_cadastro_usuario .= htmlspecialchars($e->getMessage());
            $mensagem_cadastro_usuario .= '</p></div></div><button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button></div></div>';
        }
    }
}

if (!empty($sub_pagina) && $sub_pagina === "detalhes") {
    $id_usuario = (isset($_GET['id_usuario']) ? $_GET['id_usuario'] : "");

    if (!empty($id_usuario)) {
        $buscarUsuario = $conn->prepare('SELECT id, email, nome, sobrenome, telefone, imagemPerfil, startup FROM usuarios WHERE id = ?');
        $buscarUsuario->bind_param('i', $id_usuario);
        $buscarUsuario->execute();
        $resultado = $buscarUsuario->get_result();

        if ($resultado->num_rows != 0) {

            $detalhesUsuario = $resultado->fetch_assoc();
            $buscarUsuario->close();

            $buscarStartups = $conn->prepare('SELECT id, nome FROM startups WHERE id != 1');
            $buscarStartups->execute();
            $resultados = $buscarStartups->get_result();

            $startups = [];
            while ($row = $resultados->fetch_assoc()) {
                $startups[] = $row;
            }
        } else {
            header('Location: /esta-pagina-nao-existe/');
            exit();
        }
    } else {
        header('Location: /esta-pagina-nao-existe/');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["salvarAlteracoesUsuario"])) {
        try {
            if (empty($_POST['nome']) || empty($_POST['email'])) {
                throw new Exception("Todos os campos obrigatórios devem ser preenchidos!");
            }
            if (empty($_POST['id_usuario'])) {
                throw new Exception("tentativa de atualização de usuário negada!");
            }

            $id_usuario =  $_POST['id_usuario'];
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $telefone = $_POST['telefone'];

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

            $buscar_semelhantes = $conn->prepare("SELECT * FROM usuarios WHERE (email = ? OR (LOWER(nome) = LOWER(?) AND LOWER(sobrenome) = LOWER(?))) AND ativo <> 3 AND id <> ?");
            $buscar_semelhantes->bind_param("sssi", $email, $nome['nome'], $nome['sobrenome'], $id_usuario);
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
            }

            if ($telefone != '') {
                $buscar_telefone = $conn->prepare("SELECT * FROM usuarios WHERE telefone = ? AND id <> ?");
                $buscar_telefone->bind_param("si", $telefone, $id_usuario);
                $buscar_telefone->execute();
                $resultados = $buscar_telefone->get_result();

                if ($resultados->num_rows > 0) {
                    throw new Exception("Já existe um usuário cadastrado com esse telefone!");
                }

                $buscar_telefone->close();
            }

            if (isset($_POST['startups'])) {
                $id_startup = ($_POST['startups'] == 'naocadastrado') ? 0 : intval($_POST['startups']);
                $atualizar_usuario = $conn->prepare('UPDATE usuarios SET email = ?, nome = ?, sobrenome = ?, telefone = ?, startup = ? WHERE id = ?');
                $atualizar_usuario->bind_param('ssssii', $email, $nome['nome'], $nome['sobrenome'], $telefone, $id_startup, $id_usuario);
                if (!$atualizar_usuario->execute()) {
                    throw new Exception("Erro ao tentar atualizar o usuário!");
                }
                $atualizar_usuario->close();
            } else {
                $atualizar_usuario = $conn->prepare('UPDATE usuarios SET email = ?, nome = ?, sobrenome = ?, telefone = ? WHERE id = ?');
                $atualizar_usuario->bind_param('ssssi', $email, $nome['nome'], $nome['sobrenome'], $telefone, $id_usuario);
                if (!$atualizar_usuario->execute()) {
                    throw new Exception("Erro ao tentar atualizar o usuário!");
                }
                $atualizar_usuario->close();
            }

            header("Location: /usuarios/$id_usuario/detalhes");
        } catch (Exception $e) {
            $mensagem_detalhe_usuario = '<div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon><div>';
            $mensagem_detalhe_usuario .= 'Ops, Algo de errado!';
            $mensagem_detalhe_usuario .= '<p class="fw-medium text-danger-600 text-sm mt-8">';
            $mensagem_detalhe_usuario .= htmlspecialchars($e->getMessage());
            $mensagem_detalhe_usuario .= '</p></div></div><button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button></div></div>';
        }
    }
}
