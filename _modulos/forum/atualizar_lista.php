<?php

set_include_path(get_include_path() . PATH_SEPARATOR . '/home/u890647006/domains/rywe.com.br/public_html/startufc/_credenciais/');
require_once('config.php');
session_start(); // Certifique-se de que a sessão foi iniciada
require_once('../../_lib/pages/usuarioLogado.php');

try {
    $buscar_forums = $conn->prepare("
        SELECT f.id, f.nome, f.descricao, f.criador, f.startups_participantes, 
               CONCAT(u.nome, ' ', u.sobrenome) AS nome_criador, 
               m.conteudo AS ultima_mensagem, m.dataEnvio AS dataEnvio
        FROM forum f 
        LEFT JOIN usuarios u ON f.criador = u.id
        LEFT JOIN (
            SELECT m1.forum, m1.conteudo, m1.dataEnvio
            FROM mensagens m1
            INNER JOIN (
                SELECT forum, MAX(dataEnvio) AS ultima_data
                FROM mensagens
                GROUP BY forum
            ) m2 ON m1.forum = m2.forum AND m1.dataEnvio = m2.ultima_data
        ) m ON f.id = m.forum
    ");
    $buscar_forums->execute();
    $resultados = $buscar_forums->get_result();
    $forums = [];
    while ($row = $resultados->fetch_assoc()) {
        $row['startups_participantes'] = unserialize($row['startups_participantes']);
        if ($_SESSION['nivelUsuarioLogado'] == 3 || in_array($_SESSION['startupUsuarioLogado'], $row['startups_participantes'])) {
            $forums[] = $row;
        }
    }
    echo json_encode($forums);
    exit();
} catch (Exception $e) {
    exit();
}
