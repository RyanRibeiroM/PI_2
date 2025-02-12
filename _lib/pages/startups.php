<?php
if (empty($sub_pagina)) {
    $quant_por_pagina = isset($_GET['quant_pg']) ? intval($_GET['quant_pg']) : 15;
    $pg_atual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
    $calc_pg = ($pg_atual - 1) * $quant_por_pagina;
    
    $complemento_url = "";
    $clausa = "";
    
    $complementosPermitidosStatus = [
        "ativos" => 1,
        "inativos" => 2,
        "deletados" => 3,
    ];
    
    if (!empty($complemento) && array_key_exists($complemento, $complementosPermitidosStatus)) {
        $clausa = "&& s.ativo = " . $complementosPermitidosStatus[$complemento];
        $complemento_url = $complemento . "/";
    } else if (!empty($complemento) && !array_key_exists($complemento, $complementosPermitidosStatus)) {
        header("location: /esta-pagina-nao-existe/");
    }

    $registros_total = $conn->prepare("SELECT COUNT(*) AS total FROM startups AS s WHERE s.id <> 1 ". $clausa);
    $registros_total->execute();
    $total = $registros_total->get_result();
    $total = $total->fetch_assoc();
    $registros = $total['total'];
    
    $total_pg = ceil($registros / $quant_por_pagina);
    
    $startups = $conn->prepare("SELECT s.id, s.nome, s.imagem, s.ativo, s.responsavel, s.membros, s.cnpj, CONCAT(u.nome, ' ', u.sobrenome) AS nome_responsavel FROM startups s LEFT JOIN usuarios u ON s.responsavel = u.id WHERE s.id <> 1 " . $clausa . " LIMIT ?, ?");
    $startups->bind_param("ii", $calc_pg, $quant_por_pagina);
    $startups->execute();
    $resultados = $startups->get_result();
    
    $startups = [];
    while ($row = $resultados->fetch_assoc()) {
        $startups[] = $row;
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
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["desativar_startup"])) {
            if (empty($_POST['id_startup']) || empty($_POST['cnpj_startup'])) {
                throw new Exception("Startup Inválida, falta de informações para a ação");
            }

            $id_startup = $_POST['id_startup'];
            $cnpj_startup = $_POST['cnpj_startup'];

            $mudar_ativo = $conn->prepare('UPDATE startups SET ativo = 2 WHERE id = ? AND cnpj = ?');
            $mudar_ativo->bind_param('is', $id_startup, $cnpj_startup);
            if (!$mudar_ativo->execute()) {
                throw new Exception("Erro ao desativar a startup: " . $mudar_ativo->error);
            }
            header('Location: /startups');
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["deletar_startup"])) {
            if (empty($_POST['id_startup']) || empty($_POST['cnpj_startup'])) {
                throw new Exception("Startup Inválida, falta de informações para a ação");
            }

            $id_startup = $_POST['id_startup'];
            $cnpj_startup = $_POST['cnpj_startup'];

            $mudar_ativo = $conn->prepare('UPDATE startups SET ativo = 3 WHERE id = ? AND cnpj = ?');
            $mudar_ativo->bind_param('is', $id_startup, $cnpj_startup);
            if (!$mudar_ativo->execute()) {
                throw new Exception("Erro ao deletar a startup: " . $mudar_ativo->error);
            }
            header('Location: /startups');
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["ativar_startup"])) {
            if (empty($_POST['id_startup']) || empty($_POST['cnpj_startup'])) {
                throw new Exception("Startup invalida, falta de informações para a ação");
            }

            $id_startup = $_POST['id_startup'];
            $cnpj_startup = $_POST['cnpj_startup'];

            $mudar_ativo = $conn->prepare('UPDATE startups SET ativo = 1 WHERE id = ? AND cnpj = ?');
            $mudar_ativo->bind_param('is', $id_startup, $cnpj_startup);
            if (!$mudar_ativo->execute()) {
                throw new Exception("Erro ao ativar a startup: " . $mudar_ativo->error);
            }
            header('Location: /startups');
        }
    } catch (Exception $e) {
        $mensagem_startup = '<div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon><div>';
        $mensagem_startup .= 'Ops, Algo de errado!';
        $mensagem_startup .= '<p class="fw-medium text-danger-600 text-sm mt-8">';
        $mensagem_startup .= htmlspecialchars($e->getMessage());
        $mensagem_startup .= '</p></div></div><button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button></div></div>';
    }
}


if (!empty($sub_pagina) && $sub_pagina == 'minhastartup') {

    $idbusca = $_SESSION['idUsuario'];
    $startup = $conn->prepare("SELECT startup FROM usuarios WHERE id = ?");
    $startup->bind_param("i", $idbusca);
    $startup->execute();
    $resultados = $startup->get_result();

    if ($row = $resultados->fetch_assoc()) {
        $startupbusca = $row['startup'];
    } else {
        die("Usuário não encontrado ou sem startup associada.");
    }

    $minha_startups = $conn->prepare("
    SELECT s.nome, s.cnpj, s.descricao, s.imagem, s.membros, u.nome AS responsavel 
    FROM startups s
    JOIN usuarios u ON s.responsavel = u.id
    WHERE s.id = ?
");

    $minha_startups->bind_param("i", $startupbusca);

    if (!$minha_startups->execute()) {
        die("Erro na consulta de startups.");
    }

    $resultados = $minha_startups->get_result();

    $dados = [];
    while ($row = $resultados->fetch_assoc()) {
        $dados[] = $row;
    }

    //Lista de membros na startup

    $membros = $conn->prepare("SELECT u.id, u.nome, u.sobrenome, u.email, u.telefone, u.nivel, u.ativo FROM usuarios u WHERE startup = ?");
    $membros->bind_param("i", $startupbusca);
    if (!$membros->execute()) {
        $teste = "falha";
    }
    $resultados = $membros->get_result();

    $listam = [];
    while ($row = $resultados->fetch_assoc()) {
        $listam[] = $row;
    }

    if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["excluir_membro"])) {
        if (empty($_POST['id_membro']) || empty($_POST['email_membro'])) {
            throw new Exception("Membro Inválido, falta de informações para a ação");
        }

        $id_membro = $_POST['id_membro'];
        $email_membro = $_POST['email_membro'];

        $mudar_ativo = $conn->prepare('UPDATE usuarios SET startup = 0 WHERE id = ? AND email = ?');
        $mudar_ativo->bind_param('is', $id_membro, $email_membro);
        if (!$mudar_ativo->execute()) {
            throw new Exception("Erro ao deletar o membro: " . $mudar_ativo->error);
        }
        header('Location: /startups/minha-startup');
    }

    //Edição da StartUP
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn-editarStartup'])) {
        try {
            $imagemValida = true;
            $imagemEnviada = false;
            $cnpjEnviado = false;

            if (!empty($_FILES['imagem']['name'])) {
                $imagem = basename($_FILES['imagem']['name']);
                $imagemTmp = $_FILES['imagem']['tmp_name'];
                $extensaoImagem = strtolower(pathinfo($imagem, PATHINFO_EXTENSION));
                $imagem = str_replace(' ', '', $imagem);
                $extensoesPermitidas = array("jpeg", "jpg", "png", "gif", "webp");
                $imagemEnviada = true;

                if (!verificaPixel($imagemTmp) || !in_array($extensaoImagem, $extensoesPermitidas) || $_FILES['imagem']['size'] > 3145728) {
                    throw new Exception("Imagem inválida! A imagem deve ser quadrada, ter no máximo 3MB e ser de um formato suportado.");
                }
            }

            if (!$imagemValida) {
                throw new Exception("Imagem inválida!");
            }

            if (empty($_POST['nomeStartup'])) {
                throw new Exception("Campos Vazios, insira todas as informações.");
            }

            $nomeStartup = $_POST['nomeStartup'];
            $descStartup = $_POST['descStartup'];
            $cnpj = $_POST['cnpj'];

            if (!empty($cnpj)) {
                $cnpjEnviado = true;
                if (!validarCNPJ($cnpj)) {
                    throw new Exception("CNPJ inválido!");
                }
            }

            if (strlen($nomeStartup) < 4) {
                throw new Exception("O nome é muito curto, tente inserir um nome com mais de 4 dígitos!");
            }

            if ($imagemEnviada) {
                $caminhoImagem = 'assets/images/startups/' . $startupbusca . '/';
                if (!file_exists($caminhoImagem)) {
                    mkdir($caminhoImagem, 0777, true);
                }
                $caminhoImagem .= $imagem;
                move_uploaded_file($imagemTmp, $caminhoImagem);
            }

            $dados = [
                'nome' => $nomeStartup,
                'cnpj' => $cnpj,
                'dataModificacao' => $dataHojeHora,
                'descricao' => $descStartup
            ];
            $parametros = 'ssss';

            if ($imagemEnviada) {
                $dados['imagem'] = $caminhoImagem;
                $parametros .= 's';
            }

            update('startups', $dados, 'id = ' . $startupbusca, $parametros);
            header("Location: /startups/minha-startup");
        } catch (Exception $e) {
            $mensagem_editar_startup = '<div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon><div>';
            $mensagem_editar_startup .= 'Ops, Algo de errado!';
            $mensagem_editar_startup .= '<p class="fw-medium text-danger-600 text-sm mt-8">';
            $mensagem_editar_startup .= htmlspecialchars($e->getMessage());
            $mensagem_editar_startup .= '</p></div></div><button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button></div></div>';
        }
    }
}

if (!empty($sub_pagina) && $sub_pagina === "falarcomresponsavel") {
    $idbusca = $_SESSION['idUsuario'];

    // Buscar o ID da startup associada ao usuário logado
    $startup = $conn->prepare("SELECT startup, nome, sobrenome, email FROM usuarios WHERE id = ?");
    $startup->bind_param("i", $idbusca);
    $startup->execute();
    $resultados = $startup->get_result();

    if ($row = $resultados->fetch_assoc()) {
        $startupbusca = $row['startup'];
    } else {
        die("Usuário não encontrado ou sem startup associada.");
    }
    // Buscar o ID do responsável e o e-mail do responsável
    $responsavel_query = $conn->prepare("SELECT u.id AS id_responsavel, u.email AS email_responsavel FROM startups s JOIN usuarios u ON s.responsavel = u.id WHERE s.id = ?");
    $responsavel_query->bind_param("i", $startupbusca);
    $responsavel_query->execute();
    $resultado = $responsavel_query->get_result();

    if ($dados = $resultado->fetch_assoc()) {
        $id_responsavel = $dados['id_responsavel'];
        $email_responsavel = $dados['email_responsavel'];
    } else {
        die("Responsável não encontrado.");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["falarResponsavel"])) {
        if ($_POST['assunto'] != "" && $_POST['conteudo'] != "") {

            $nomeC = $row['nome'] . " " . $row['sobrenome'];
            $emailC = $row['email'];

            $nome = strip_tags(trim($nomeC));
            $nome = str_replace(array("\r", "\n"), array(" ", ""), $nome);

            $email = strip_tags(trim($emailC));
            $email = str_replace(array("\r", "\n"), array(" ", ""), $email);

            $assunto = strip_tags(trim($_POST['assunto']));
            $assunto = str_replace(array("\r", "\n"), array(" ", ""), $assunto);

            $conteudo = strip_tags(trim($_POST['conteudo']));
            $conteudo = str_replace(array("\r", "\n"), array(" ", ""), $conteudo);

            $emailDestinatario = 'tiagoufcuni@gmail.com';

            $corpoEmail = "Nome: $nome\n";
            $corpoEmail .= "Email: $email\n";
            $corpoEmail .= "Conteudo: $conteudo\n";

            $cabecalho = "De: $nome <$email>";


            mail($emailDestinatario, $assunto, $corpoEmail, $cabecalho);
        }
    }
}

if (!empty($sub_pagina) && $sub_pagina === "cadastrar") {
    try {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["cadastrar_startup"])) {
            if (empty($_FILES['imagem']['name']) || empty($_POST['nome']) || empty($_POST['cnpj']) || empty($_POST['responsavel']) || empty($_POST['descricao'])) {
                throw new Exception("Todos os campos são obrigatórios!");
            }

            $imagemValida = true;

            if (!empty($_FILES['imagem']['name'])) {
                $imagem = basename($_FILES['imagem']['name']);
                $imagemTmp = $_FILES['imagem']['tmp_name'];
                $extensaoImagem = strtolower(pathinfo($imagem, PATHINFO_EXTENSION));
                $imagem = str_replace(' ', '', basename($_FILES['imagem']['name']));
                $extensoesPermitidas = array("jpeg", "jpg", "png", "gif", "webp");
                if (!verificaPixel($imagemTmp) || !in_array($extensaoImagem, $extensoesPermitidas) || $_FILES['imagem']['size'] > 3145728) {
                    $imagemValida = false;
                }
            }

            if (!$imagemValida) {
                throw new Exception("Imagem Inválida.A imagem deve ter largura e altura igual, ter no máximo 3MB de tamanho e ser um formato suportado (.jpeg, .jpg, .png, .gif, .webp)");
            }

            $nome = $_POST['nome'];
            $cnpj = $_POST['cnpj'];
            $responsavel = $_POST['responsavel'];
            $nome_responsavel = separarNome($responsavel);
            $descricao = $_POST['descricao'];

            if (strlen($nome) < 4) {
                throw new Exception("O nome é muito curto tente inserir um nome com mas de 4 dígitos!");
            }

            if (!validarCNPJ($cnpj)) {
                throw new Exception("CNPJ inválido!");
            }

            // Verificar se já existe uma startup com o mesmo nome ou CNPJ
            $stmt = $conn->prepare("SELECT id FROM startups WHERE nome = ? OR cnpj = ?");
            $stmt->bind_param("ss", $nome, $cnpj);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                throw new Exception("Já existe uma startup com esse nome ou CNPJ!");
            }
            $stmt->close();

            // Verificar se o responsável existe no banco de dados de usuários
            $stmt = $conn->prepare("SELECT id, nivel, ativo FROM usuarios WHERE (LOWER(nome) = LOWER(?) AND LOWER(sobrenome) = LOWER(?) AND ativo = 1 ) OR email = ? ");
            $stmt->bind_param("sss", $nome_responsavel['nome'], $nome_responsavel['sobrenome'], $responsavel);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 0) {
                throw new Exception("Responsável não encontrado!");
            }
            $usuario = $result->fetch_assoc();
            $responsavel_id = $usuario['id'];
            $stmt->close();

            // Verificar o nível do usuário
            if ($usuario['nivel'] == 3 || $usuario['ativo'] != 1) {
                throw new Exception("Esse usuário não pode ser responsavel por essa startup!");
            }

            // Inserir a startup no banco de dados
            $stmt = $conn->prepare("INSERT INTO startups (nome, cnpj, responsavel, descricao) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssis", $nome, $cnpj, $responsavel_id, $descricao);
            if (!$stmt->execute()) {
                throw new Exception("Erro ao cadastrar a startup. Por favor, tente novamente.");
            }
            $stmt->close();
            $startup_id = $conn->insert_id;

            $stmt = $conn->prepare("UPDATE usuarios SET nivel = 2, startup = ? WHERE id = ?");
            $stmt->bind_param("ii", $startup_id, $responsavel_id);
            if (!$stmt->execute()) {
                throw new Exception("Erro ao atualizar o nível do usuário. Por favor, tente novamente.");
            }
            $stmt->close();

            // Definir o caminho da imagem com o ID da startup
            $caminhoImagem = 'assets/images/startups/' . $startup_id . '/' . $imagem;
            if (!file_exists(dirname($caminhoImagem))) {
                mkdir(dirname($caminhoImagem), 0777, true);
            }
            move_uploaded_file($imagemTmp, $caminhoImagem);

            // Atualizar o caminho da imagem no banco de dados
            $stmt = $conn->prepare("UPDATE startups SET imagem = ? WHERE id = ?");
            $stmt->bind_param("si", $caminhoImagem, $startup_id);
            if (!$stmt->execute()) {
                throw new Exception("Erro ao atualizar o caminho da imagem. Por favor, tente novamente.");
            }
            $stmt->close();

            $forum_startup_id[$startup_id] = $startup_id;
            $dados_serializados = serialize($forum_startup_id);
            $descricao = "Fórum da startup " . $nome;

            $stmt = $conn->prepare("INSERT INTO forum (nome, criador, descricao, startups_participantes) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("siss", $nome, $usuarioLogado['id'], $descricao, $dados_serializados);
            if (!$stmt->execute()) {
                throw new Exception("Erro ao criar o fórum da startup. Por favor, tente novamente.");
            }
            $stmt->close();

            header("Location: /startups");
        }
    } catch (Exception $e) {
        $mensagem_cadastro_startup = '<div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon><div>';
        $mensagem_cadastro_startup .= 'Ops, Algo de errado!';
        $mensagem_cadastro_startup .= '<p class="fw-medium text-danger-600 text-sm mt-8">';
        $mensagem_cadastro_startup .= htmlspecialchars($e->getMessage());
        $mensagem_cadastro_startup .= '</p></div></div><button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button></div></div>';
    }
}

if (!empty($sub_pagina) && $sub_pagina === "adicionar-aviso") {
    try {
        $buscarStartups = $conn->prepare("SELECT id, nome FROM startups WHERE id <> 1");
        $buscarStartups->execute();
        $resultados = $buscarStartups->get_result();
        $startups = [];

        while ($row = $resultados->fetch_assoc()) {
            $startups[] = $row;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["cadastrarAviso"])) {

            if (empty($_POST['assunto']) || empty($_POST['descricao']) || empty($_POST['startup'])) {
                throw new Exception("Todos os campos são obrigatórios!");
            }
            $assunto = $_POST['assunto'];
            $descricao = $_POST['descricao'];
            $startups_participantes = $_POST['startup'];
            $serializado_startups = serialize($startups_participantes);
            $tipo = 'startups';

            if (strlen($assunto) < 4) {
                throw new Exception("O Assunto deve ter no mínimo 4 caracteres!");
            }
            if (strlen($descricao) < 4) {
                throw new Exception("A descrição está muito curta para esse aviso tenter detalhar mais o objetivo desse aviso!");
            }

            $inserirAviso = $conn->prepare("
            INSERT INTO avisos(tipo, assunto, conteudo, destinatarios, remetente, data_envio)
            VALUES ( ?, ?, ?, ?, ?, ?)
            ");
            $inserirAviso->bind_param("ssssis", $tipo, $assunto, $descricao, $serializado_startups, $usuarioLogado['id'], $dataHojeHora);
            $inserirAviso->execute();
            $inserirAviso->close();
        }
    } catch (Exception $e) {
        $mensagem_cadastro_aviso = '<div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon><div>';
        $mensagem_cadastro_aviso .= 'Ops, Algo de errado!';
        $mensagem_cadastro_aviso .= '<p class="fw-medium text-danger-600 text-sm mt-8">';
        $mensagem_cadastro_aviso .= htmlspecialchars($e->getMessage());
        $mensagem_cadastro_aviso .= '</p></div></div><button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button></div></div>';
    }
}
