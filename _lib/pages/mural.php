<?php
if (empty($sub_pagina)) {
    if ($usuarioLogado['nivel'] == 3) {
        $buscar_mural = $conn->prepare("SELECT * FROM mural ORDER BY id DESC");
        $buscar_mural->execute();
        $resultados = $buscar_mural->get_result();
    } else {
        $buscar_mural = $conn->prepare("SELECT * FROM mural WHERE compartilhador = ? ORDER BY id DESC");
        $buscar_mural->bind_param("i", $usuarioLogado['id']);
        $buscar_mural->execute();
        $resultados = $buscar_mural->get_result();
    }

    $murais = [];
    while ($row = $resultados->fetch_assoc()) {
        $row['imagens'] = unserialize($row['imagens']);
        $murais[] = $row;
    }

    try {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["apagar-mural"])) {
            $idMural = $_POST["id-mural"];
            $tituloMural = $_POST["titulo-mural"];

            if ($usuarioLogado['nivel'] == 3) {
                $stmt = $conn->prepare("DELETE FROM mural WHERE id = ? AND titulo = ?");
                $stmt->bind_param("is", $idMural, $tituloMural);
                $stmt->execute();
            } else {
                $buscar_compartilhador = $conn->prepare("SELECT compartilhador FROM mural WHERE id = ?");
                $buscar_compartilhador->bind_param("i", $idMural);
                $buscar_compartilhador->execute();
                $resultados = $buscar_compartilhador->get_result();
                $compartilhador = $resultados->fetch_assoc();

                if ($compartilhador['compartilhador'] == $usuarioLogado['id']) {
                    $stmt = $conn->prepare("DELETE FROM mural WHERE id = ? AND titulo = ?");
                    $stmt->bind_param("is", $idMural, $tituloMural);
                    $stmt->execute();
                } else {
                    throw new Exception("Você não tem permissão para apagar este mural.");
                }
            }

            $pastaMural = "assets/images/mural/" . $idMural;
            if (is_dir($pastaMural)) {
                array_map('unlink', glob("$pastaMural/*.*"));
                rmdir($pastaMural);
            }

            header("Location: /mural");
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["desativar-mural"])) {
            $idMural = $_POST["id-mural"];
            $tituloMural = $_POST["titulo-mural"];

            if ($usuarioLogado['nivel'] == 3) {
                $stmt = $conn->prepare("UPDATE mural SET ativo = 2 WHERE id = ? AND titulo = ?");
                $stmt->bind_param("is", $idMural, $tituloMural);
                $stmt->execute();
            } else {
                $buscar_compartilhador = $conn->prepare("SELECT compartilhador FROM mural WHERE id = ?");
                $buscar_compartilhador->bind_param("i", $idMural);
                $buscar_compartilhador->execute();
                $resultados = $buscar_compartilhador->get_result();
                $compartilhador = $resultados->fetch_assoc();

                if ($compartilhador['compartilhador'] == $usuarioLogado['id']) {
                    $stmt = $conn->prepare("UPDATE mural SET ativo = 2 WHERE id = ? AND titulo = ?");
                    $stmt->bind_param("is", $idMural, $tituloMural);
                    $stmt->execute();
                } else {
                    throw new Exception("Você não tem permissão para desativar este mural.");
                }
            }

            header("Location: /mural");
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["ativar-mural"])) {
            $idMural = $_POST["id-mural"];
            $tituloMural = $_POST["titulo-mural"];

            if ($usuarioLogado['nivel'] == 3) {
                $stmt = $conn->prepare("UPDATE mural SET ativo = 1 WHERE id = ? AND titulo = ?");
                $stmt->bind_param("is", $idMural, $tituloMural);
                $stmt->execute();
            } else {
                $buscar_compartilhador = $conn->prepare("SELECT compartilhador FROM mural WHERE id = ?");
                $buscar_compartilhador->bind_param("i", $idMural);
                $buscar_compartilhador->execute();
                $resultados = $buscar_compartilhador->get_result();
                $compartilhador = $resultados->fetch_assoc();
                $buscar_compartilhador->close();

                if ($compartilhador['compartilhador'] == $usuarioLogado['id']) {

                    $num_mural_ativo = $conn->prepare("SELECT COUNT(*) as total FROM mural WHERE ativo = 1 AND compartilhador = ?");
                    $num_mural_ativo->bind_param("i", $usuarioLogado['id']);
                    $num_mural_ativo->execute();
                    $resultados = $num_mural_ativo->get_result();
                    $num_mural_ativo = $resultados->fetch_assoc();
                    $num_mural_ativo = $num_mural_ativo['total'];

                    if ($num_mural_ativo >= 3) {
                        throw new Exception("Você já atingiu o limite de murais ativos (3). Por favor, desative um mural antes de ativar outro.");
                    }

                    $stmt = $conn->prepare("UPDATE mural SET ativo = 1 WHERE id = ? AND titulo = ?");
                    $stmt->bind_param("is", $idMural, $tituloMural);
                    $stmt->execute();
                } else {
                    throw new Exception("Você não tem permissão para ativar este mural.");
                }
            }

            header("Location: /mural");
        }
    } catch (Exception $e) {
        $mensagem_mural = '<div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon><div>';
        $mensagem_mural .= 'Ops, Algo de errado!';
        $mensagem_mural .= '<p class="fw-medium text-danger-600 text-sm mt-8">';
        $mensagem_mural .= htmlspecialchars($e->getMessage());
        $mensagem_mural .= '</p></div></div><button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button></div></div>';
    }
}

if (!empty($sub_pagina) && $sub_pagina === "cadastrar") {
    try {

        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["novo_mural"])) {
            $titulo = $_POST["titulo"];
            $texto = $_POST["texto"];
            $tipo = $_POST["tipos_mural"];
            $imagens = $_FILES["imagem"];

            if (empty($titulo) || empty($texto) || empty($tipo) || empty($imagens)) {
                throw new Exception("Preencha todos os campos obrigatórios!");
            }

            if (strlen($titulo) < 5 || strlen($titulo) > 50) {
                throw new Exception("O título do mural deve ter no mínimo 5 caracteres e no máximo 50 caracteres.");
            }

            if (strlen($texto) < 5 || strlen($texto) > 255) {
                throw new Exception("O texto do mural deve ter no mínimo 5 caracteres e no máximo 255 caracteres.");
            }

            if ($tipo != "unico" && $tipo != "carrosel") {
                throw new Exception("Tipo de mural inválido.");
            }

            if (($tipo === "unico" && count($imagens["name"]) > 1) || ($tipo === "carrosel" && count($imagens["name"]) > 10)) {
                throw new Exception("A quantidade de imagens enviadas é inválida para o tipo de mural selecionado.");
            }

            $imagensValidas = [];
            $errosImagens = [];
            foreach ($imagens['name'] as $index => $imagem) {
                $imagemValida = true;
                $imagemEnviada = false;
                if (!empty($imagem)) {
                    $imagemTmp = $imagens['tmp_name'][$index];
                    $extensaoImagem = strtolower(pathinfo($imagem, PATHINFO_EXTENSION));
                    $imagem = str_replace(' ', '', basename($imagem));
                    $extensoesPermitidas = array("jpeg", "jpg", "png", "gif", "webp");
                    $imagemEnviada = true;
                    if (!in_array($extensaoImagem, $extensoesPermitidas)) {
                        $imagemValida = false;
                        $errosImagens[] = "Extensão inválida para a imagem: $imagem";
                    } else if ($imagens['size'][$index] > 3145728) {
                        $imagemValida = false;
                        $errosImagens[] = "Tamanho excedido para a imagem: $imagem";
                    }
                }
                if ($imagemValida && $imagemEnviada) {
                    $imagensValidas[] = [
                        'nome' => $imagem,
                        'tmp_name' => $imagemTmp
                    ];
                }
            }

            if (!empty($errosImagens)) {
                $mensagemErro = "Algumas imagens não são válidas. Erros: " . implode(", ", $errosImagens);
                throw new Exception($mensagemErro);
            }

            if ($usuarioLogado['nivel'] != 3) {
                $num_mural_ativo = $conn->prepare("SELECT COUNT(*) as total FROM mural WHERE ativo = 1 AND compartilhador = ?");
                $num_mural_ativo->bind_param("i", $usuarioLogado['id']);
                $num_mural_ativo->execute();
                $resultados = $num_mural_ativo->get_result();
                $num_mural_ativo = $resultados->fetch_assoc();
                $num_mural_ativo = $num_mural_ativo['total'];

                if ($num_mural_ativo >= 3) {
                    // Desativar o mural mais antigo ativo
                    $desativar_mural_antigo = $conn->prepare("UPDATE mural SET ativo = 2 WHERE id = (SELECT id FROM mural WHERE ativo = 1 AND compartilhador = ? ORDER BY id ASC LIMIT 1)");
                    $desativar_mural_antigo->bind_param("i", $usuarioLogado['id']);
                    $desativar_mural_antigo->execute();
                }
            }

            $stmt = $conn->prepare("INSERT INTO mural (titulo, texto, tipo, compartilhador) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $titulo, $texto, $tipo, $usuarioLogado['id']);
            $stmt->execute();

            $muralId = $conn->insert_id;
            $pastaMural = "assets/images/mural/" . $muralId;
            if (!is_dir($pastaMural)) {
                mkdir($pastaMural, 0777, true);
            }

            $caminhosImagens = [];
            foreach ($imagensValidas as $imagem) {
                $caminhoImagem = $pastaMural . "/" . $imagem['nome'];
                redimensionarImagem($imagem['tmp_name'], $caminhoImagem, 768, 455);
                $caminhosImagens[] = $caminhoImagem;
            }

            $stmt = $conn->prepare("UPDATE mural SET imagens = ? WHERE id = ?");
            $imagensSerializadas = serialize($caminhosImagens);
            $stmt->bind_param("si", $imagensSerializadas, $muralId);
            $stmt->execute();
            header("Location: /mural");
        }
    } catch (Exception $e) {
        $mensagem_mural = '<div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon><div>';
        $mensagem_mural .= 'Ops, Algo de errado!';
        $mensagem_mural .= '<p class="fw-medium text-danger-600 text-sm mt-8">';
        $mensagem_mural .= htmlspecialchars($e->getMessage());
        $mensagem_mural .= '</p></div></div><button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button></div></div>';
    }
}
