<?php
if (empty($sub_pagina)) {
    try {
        if (!empty($id_forum)) {
            $buscar_forum = $conn->prepare("SELECT nome, descricao, criador, startups_participantes FROM forum WHERE id = ?");
            $buscar_forum->bind_param("i", $id_forum);
            $buscar_forum->execute();
            $resultados = $buscar_forum->get_result();

            if ($resultados->num_rows === 0) {
                header("Location: /esta-pagina-nao-existe/");
                exit();
            }

            $forum = $resultados->fetch_assoc();
            $participantes_forum = unserialize($forum['startups_participantes']);
            $buscar_forum->close();
          

            if (!in_array($usuarioLogado['startup'], $participantes_forum) && !verificaAcesso($usuarioLogado['nivel'], $acessoUFC)) {
                header("Location: /esta-pagina-nao-existe/");
                exit();
            }

            $buscar_mensagens = $conn->prepare("SELECT m.id, m.conteudo, m.dataEnvio, m.remetente, CONCAT(u.nome, ' ', u.sobrenome) AS remetente_nome, u.imagemPerfil FROM mensagens AS m LEFT JOIN usuarios AS u ON m.remetente = u.id WHERE m.forum = ? ORDER BY m.dataEnvio ASC");
            $buscar_mensagens->bind_param("i", $id_forum);
            $buscar_mensagens->execute();
            $resultados = $buscar_mensagens->get_result();
            $mensagens = [];



            while ($row = $resultados->fetch_assoc()) {
                $mensagens[] = $row;
            }
            $buscar_mensagens->close();

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["excluir_mensagem_forum"])) {
                $id_forum_apagar = $_POST['id_forum'];

                if ($id_forum_apagar != $id_forum) {
                    throw new Exception("Ação Inválida!");
                }

                if ($usuarioLogado['nivel'] != 3) {
                    throw new Exception("Você não tem permissão para realizar essa ação!");
                }

                $excluir_mensagens = $conn->prepare("DELETE FROM mensagens WHERE forum = ?");
                $excluir_mensagens->bind_param("i", $id_forum_apagar);
                if (!$excluir_mensagens->execute()) {
                    throw new Exception("Falha ao excluir mensagens!");
                }
                $excluir_mensagens->close();
                header("Location: /forum/$id_forum");
            }
        }
    } catch (Exception $e) {
        $mensagem_forum = '<div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon><div>';
        $mensagem_forum .= 'Ops, Algo de errado!';
        $mensagem_forum .= '<p class="fw-medium text-danger-600 text-sm mt-8">';
        $mensagem_forum .= htmlspecialchars($e->getMessage());
        $mensagem_forum .= '</p></div></div><button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button></div></div>';
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

    try {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["cadastrar_forum"])) {
            if (empty($_POST['nome']) || empty($_POST['descricao']) || empty($_POST['startups'])) {
                throw new Exception("Todos os campos são obrigatórios!");
            }
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $startups_participantes = $_POST['startups'];
            $serializado_startups = serialize($startups_participantes);

            if (strlen($nome) < 4) {
                throw new Exception("O nome do fórum deve ter no mínimo 4 caracteres!");
            }
            if (strlen($descricao) < 4) {
                throw new Exception("A descrição está muito curta para o fórum tenter detalhar mais o objetivo desse fórum!");
            }

            $cadastrarForum = $conn->prepare("INSERT INTO forum (nome, descricao, criador, startups_participantes) VALUES (?, ?, ?, ?)");
            $cadastrarForum->bind_param("ssis", $nome, $descricao, $usuarioLogado['id'], $serializado_startups);
            if (!$cadastrarForum->execute()) {
                throw new Exception("Falha ao cadastrar fórum!");
            }
            $testando = var_dump($_POST['startups']);
            header("Location: /forum");
        }
    } catch (Exception $e) {
        $mensagem_cadastro_forum = '<div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon><div>';
        $mensagem_cadastro_forum .= 'Ops, Algo de errado!';
        $mensagem_cadastro_forum .= '<p class="fw-medium text-danger-600 text-sm mt-8">';
        $mensagem_cadastro_forum .= htmlspecialchars($e->getMessage());
        $mensagem_cadastro_forum .= '</p></div></div><button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button></div></div>';
    }
}
