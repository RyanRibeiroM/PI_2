<?php
set_include_path(get_include_path() . PATH_SEPARATOR . '/home/u890647006/domains/rywe.com.br/public_html/startufc/_credenciais/');
require_once('config.php');

function formatarDataMensagem($data)
{
    $dataAtual = new DateTime();
    $dataMensagem = new DateTime($data);
    $intervalo = $dataAtual->diff($dataMensagem);

    if ($intervalo->days == 0 && $intervalo->h == 0 && $intervalo->i < 3) {
        return "enviada agora";
    }

    if ($dataAtual->format('Y-m-d') == $dataMensagem->format('Y-m-d')) {
        return "hoje às " . $dataMensagem->format('H:i:s');
    }

    $dataOntem = (clone $dataAtual)->modify('-1 day');
    if ($dataOntem->format('Y-m-d') == $dataMensagem->format('Y-m-d')) {
        return "ontem às " . $dataMensagem->format('H:i:s');
    }

    return $dataMensagem->format('d/m/Y') . " às " . $dataMensagem->format('H:i:s');
}

$id_forum = isset($_POST['id_forum']) ? intval($_POST['id_forum']) : 0;

if ($id_forum > 0) {
    $buscar_mensagens = $conn->prepare("SELECT m.id, m.conteudo, m.dataEnvio, m.remetente, CONCAT(u.nome, ' ', u.sobrenome) AS remetente_nome, u.imagemPerfil FROM mensagens AS m LEFT JOIN usuarios AS u ON m.remetente = u.id WHERE m.forum = ? ORDER BY m.dataEnvio ASC");
    $buscar_mensagens->bind_param("i", $id_forum);
    $buscar_mensagens->execute();
    $resultados = $buscar_mensagens->get_result();
    $mensagens = [];

    while ($row = $resultados->fetch_assoc()) {
        $row['dataEnvio'] = formatarDataMensagem($row['dataEnvio']);
        $mensagens[] = $row;
    }
    $buscar_mensagens->close();

    echo json_encode($mensagens);
}
