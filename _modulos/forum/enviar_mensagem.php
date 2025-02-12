<?php
set_include_path(get_include_path() . PATH_SEPARATOR . '/home/u890647006/domains/rywe.com.br/public_html/startufc/_credenciais/');
require_once('config.php');
date_default_timezone_set('America/Sao_Paulo');

$id_forum = isset($_POST['id_forum']) ? intval($_POST['id_forum']) : 0;
$id_usuario = isset($_POST['id_usuario']) ? intval($_POST['id_usuario']) : 0;
$mensagem = isset($_POST['mensagem']) ? trim($_POST['mensagem']) : '';

if ($id_forum > 0 && $id_usuario > 0 && !empty($mensagem)) {
    $mensagem = htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8');
    $dataEnvio = date("Y-m-d H:i:s");

    $sql = $conn->prepare("INSERT INTO mensagens (forum, remetente, conteudo, dataEnvio) VALUES (?, ?, ?, ?)");
    $sql->bind_param("iiss", $id_forum, $id_usuario, $mensagem, $dataEnvio);
    $sql->execute();
    $sql->close();
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Dados inválidos']);
}
