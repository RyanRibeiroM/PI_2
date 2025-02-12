<?php
try {
    if (!empty($sub_pagina) && $sub_pagina === "avisos") {
        if (empty($id_aviso)) {
            $buscarTodosAvisos = $conn->prepare("SELECT id, tipo, destinatarios, excluido_por FROM avisos");
            $buscarTodosAvisos->execute();
            $resultados = $buscarTodosAvisos->get_result();
            $buscarTodosAvisos->close();
            $avisosDoUsuario = [];
            while ($row = $resultados->fetch_assoc()) {
                $row['destinatarios'] = unserialize($row['destinatarios']);

                if (!empty($row['excluido_por'])) {
                    $apagado_por = unserialize($row['excluido_por']);
                    if (in_array($usuarioLogado['id'], $apagado_por)) {
                        continue;
                    }
                }

                if ($row['tipo'] == 'usuarios' && in_array($usuarioLogado['id'], $row['destinatarios'])) {
                    $avisosDoUsuario[] = $row['id'];
                }

                if ($row['tipo'] == 'startups' && in_array($usuarioLogado['startup'], $row['destinatarios'])) {
                    $avisosDoUsuario[] = $row['id'];
                }
            }

            if (!empty($avisosDoUsuario)) {
                $idsAvisos = implode(',', array_fill(0, count($avisosDoUsuario), '?'));
                $buscarAvisosUsuario = $conn->prepare("
                    SELECT a.*, CONCAT(u.nome, ' ', u.sobrenome) AS remetente_nome
                    FROM avisos AS a
                    LEFT JOIN usuarios AS u ON a.remetente = u.id
                    WHERE a.id IN ($idsAvisos)
                ");
                $tipos = str_repeat('i', count($avisosDoUsuario));
                $buscarAvisosUsuario->bind_param($tipos, ...$avisosDoUsuario);
                $buscarAvisosUsuario->execute();
                $resultadosAvisosUsuario = $buscarAvisosUsuario->get_result();
                $buscarAvisosUsuario->close();

                $avisos = [];
                while ($row = $resultadosAvisosUsuario->fetch_assoc()) {
                    $avisos[] = $row;
                }
            }
        } else {
            $verificaAcessoAviso = $conn->prepare("SELECT tipo, destinatarios, lido_por, excluido_por FROM avisos WHERE id = ?");
            $verificaAcessoAviso->bind_param("i", $id_aviso);
            $verificaAcessoAviso->execute();
            $resultados = $verificaAcessoAviso->get_result();
            $acessoAviso = $resultados->fetch_assoc();
            $verificaAcessoAviso->close();

            $usuarioTemAcesso = false;
            $acessoAviso['destinatarios'] = unserialize($acessoAviso['destinatarios']);

            if (!empty($acessoAviso['excluido_por'])) {
                $apagado_por = unserialize($acessoAviso['excluido_por']);
                if (in_array($usuarioLogado['id'], $apagado_por)) {
                    header("Location: /esta-pagina-nao-existe/");
                    exit();
                }
            }

            if ($acessoAviso['tipo'] === 'usuarios' && in_array($usuarioLogado['id'], $acessoAviso['destinatarios'])) {
                $usuarioTemAcesso = true;
            }
            if ($acessoAviso['tipo'] === 'startups' && in_array($usuarioLogado['startup'], $acessoAviso['destinatarios'])) {
                $usuarioTemAcesso = true;
            }

            if ($usuarioTemAcesso === false) {
                header("Location: /esta-pagina-nao-existe/");
                exit();
            }

            if (!empty($acessoAviso['lido_por'])) {
                $acessoAviso['lido_por'] = unserialize($acessoAviso['lido_por']);
            } else {
                $acessoAviso['lido_por'] = [];
            }

            if (!in_array($usuarioLogado['id'], $acessoAviso['lido_por'])) {
                $acessoAviso['lido_por'][] = $usuarioLogado['id'];
                $acessoAviso['lido_por'] = serialize($acessoAviso['lido_por']);

                $atualizarLidoPor = $conn->prepare("UPDATE avisos SET lido_por = ? WHERE id = ?");
                $atualizarLidoPor->bind_param("si", $acessoAviso['lido_por'], $id_aviso);
                $atualizarLidoPor->execute();
            }

            $buscarAviso = $conn->prepare("SELECT a.id, a.assunto, a.conteudo, a.data_envio, a.excluido_por, CONCAT(u.nome, ' ', u.sobrenome) AS remetente_nome, u.imagemPerfil AS remetente_imagemPerfil FROM avisos AS a LEFT JOIN usuarios AS u ON a.remetente = u.id WHERE a.id = ?");
            $buscarAviso->bind_param("i", $id_aviso);
            $buscarAviso->execute();
            $resultados = $buscarAviso->get_result();
            $aviso = $resultados->fetch_assoc();

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['apagar-aviso'])) {
                $excluido_sql = [];
                if (empty($aviso['excluido_por'])) {
                    $excluido_sql = [$usuarioLogado['id']];
                } else {
                    $excluido_sql = unserialize($aviso['excluido_por']);
                    $excluido_sql[] = $usuarioLogado['id'];
                }
                $excluido_sql = serialize($excluido_sql);

                $apagarAviso = $conn->prepare('UPDATE avisos SET excluido_por = ? WHERE id = ?');
                $apagarAviso->bind_param('si', $excluido_sql, $aviso['id']);
                $apagarAviso->execute();
                $apagarAviso->close();

                header("Location: /caixa-de-entrada/avisos");
            }
        }
    }

    if (!empty($id_caixaDeMensagem)) {
        $verificaAcessoCaixaDeMensagem = $conn->prepare("
        SELECT c.id, c.remetente, c.concluido_por, c.excluido_por, 
        CONCAT(u1.nome, ' ', u1.sobrenome) AS remetente_nome,
        CONCAT(u2.nome, ' ', u2.sobrenome) AS destinatario_nome
        FROM caixa AS c
        LEFT JOIN usuarios u1 ON c.remetente = u1.id
        LEFT JOIN usuarios u2 ON c.destinatario = u2.id
        WHERE c.id = ? AND (c.remetente = ? OR c.destinatario = ?)");
        $verificaAcessoCaixaDeMensagem->bind_param("iii", $id_caixaDeMensagem, $usuarioLogado['id'], $usuarioLogado['id']);
        $verificaAcessoCaixaDeMensagem->execute();
        $resultados = $verificaAcessoCaixaDeMensagem->get_result();
        $verificaAcessoCaixaDeMensagem->close();

        if ($resultados->num_rows == 0) {
            header("Location: /esta-pagina-nao-existe/");
            exit();
        }
        $caixa = $resultados->fetch_assoc();

        if (!empty($caixa['excluido_por'])) {
            $excluido_por = unserialize($caixa['excluido_por']);
            if (in_array($usuarioLogado['id'], $excluido_por)) {
                header("Location: /esta-pagina-nao-existe/");
                exit();
            }
        }

        $buscarMensagens = $conn->prepare("
        SELECT mc.*,
        CONCAT(u1.nome, ' ', u1.sobrenome) AS remetente_nome,
        u1.imagemPerfil AS remetente_imagemPerfil,
        u1.email AS remetente_email
        FROM mensagens_caixa AS mc
        LEFT JOIN usuarios u1 ON mc.remetente = u1.id
        WHERE mc.caixa = ? ORDER BY mc.data_envio ASC
        ");
        $buscarMensagens->bind_param("i", $id_caixaDeMensagem);
        $buscarMensagens->execute();
        $resultados = $buscarMensagens->get_result();
        $buscarMensagens->close();

        $mensagens = [];
        while ($row = $resultados->fetch_assoc()) {
            $mensagens[] = $row;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['enviar_resposta_caixa'])) {
            $conteudo = $_POST['conteudo'];

            if (empty($conteudo)) {
                throw new Exception("A mensagem não pode ser enviada vazia!");
            }

            $inserirMensagem = $conn->prepare("
            INSERT INTO mensagens_caixa (caixa, conteudo, data_envio, remetente)
            VALUES (?, ?, ?, ?)
            ");
            $inserirMensagem->bind_param("issi", $id_caixaDeMensagem, $conteudo, $dataHojeHora, $usuarioLogado['id']);
            $inserirMensagem->execute();
            $inserirMensagem->close();

            if (!empty($caixa['excluido_por'])) {
                $excluido_por = "";
                $atualizarExcluidoPor = $conn->prepare("UPDATE caixa SET excluido_por = ? WHERE id = ?");
                $atualizarExcluidoPor->bind_param("si", $excluido_por, $id_caixaDeMensagem);
                $atualizarExcluidoPor->execute();
                $atualizarExcluidoPor->close();
            }

            header("Location: /caixa-de-entrada/$id_caixaDeMensagem/detalhes");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['concluir-caixa'])) {
            $concluirCaixa = $conn->prepare('UPDATE caixa SET concluido_por = ? WHERE id = ?');
            $concluirCaixa->bind_param('ii', $usuarioLogado['id'], $id_caixaDeMensagem);
            $concluirCaixa->execute();
            $concluirCaixa->close();

            header("Location: /caixa-de-entrada/$id_caixaDeMensagem/detalhes");
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['apagar-caixa'])) {
            $excluido_sql = [];
            if (empty($caixa['excluido_por'])) {
                $excluido_sql = [$usuarioLogado['id']];
            } else {
                $excluido_sql = unserialize($caixa['excluido_por']);
                $excluido_sql[] = $usuarioLogado['id'];
            }
            $excluido_sql = serialize($excluido_sql);

            $apagarCaixa = $conn->prepare('UPDATE caixa SET excluido_por = ? WHERE id = ?');
            $apagarCaixa->bind_param('si', $excluido_sql, $id_caixaDeMensagem);
            $apagarCaixa->execute();
            $apagarCaixa->close();

            header("Location: /caixa-de-entrada");
        }
    }

    if (empty($sub_pagina) && empty($id_caixaDeMensagem)) {
        $buscarCaixasDeMensagens = $conn->prepare("
            SELECT c.*, 
                   CONCAT(u1.nome, ' ', u1.sobrenome) AS remetente_nome, 
                   CONCAT(u2.nome, ' ', u2.sobrenome) AS destinatario_nome, 
                   sub.ultima_mensagem, 
                   sub.ultima_data_envio
            FROM caixa c
            LEFT JOIN usuarios u1 ON c.remetente = u1.id
            LEFT JOIN usuarios u2 ON c.destinatario = u2.id
            LEFT JOIN (
                SELECT caixa, 
                       conteudo AS ultima_mensagem, 
                       data_envio AS ultima_data_envio
                FROM mensagens_caixa
                ORDER BY data_envio DESC
                LIMIT 1
            ) sub ON c.id = sub.caixa
            WHERE c.destinatario = ? OR c.remetente = ?
        ");
        $buscarCaixasDeMensagens->bind_param("ii", $usuarioLogado['id'], $usuarioLogado['id']);
        $buscarCaixasDeMensagens->execute();
        $resultados = $buscarCaixasDeMensagens->get_result();
        $buscarCaixasDeMensagens->close();
        $caixas = [];

        while ($row = $resultados->fetch_assoc()) {
            if (!empty($row['excluido_por'])) {
                $excluido_por = unserialize($row['excluido_por']);
                if (!in_array($usuarioLogado['id'], $excluido_por)) {
                    $caixas[] = $row;
                }
            } else {
                $caixas[] = $row;
            }
        }
    }
} catch (Exception $e) {
    $mensagem_caixaDeEntrada = '<div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon><div>';
    $mensagem_caixaDeEntrada .= 'Ops, Algo de errado!';
    $mensagem_caixaDeEntrada .= '<p class="fw-medium text-danger-600 text-sm mt-8">';
    $mensagem_caixaDeEntrada .= htmlspecialchars($e->getMessage());
    $mensagem_caixaDeEntrada .= '</p></div></div><button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button></div></div>';
}
