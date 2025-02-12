
<?php
$buscarTodosAvisos = $conn->prepare("SELECT id, tipo, destinatarios, lido_por FROM avisos");
$buscarTodosAvisos->execute();
$resultados = $buscarTodosAvisos->get_result();
$buscarTodosAvisos->close();
$avisosDoUsuario = [];

while ($row = $resultados->fetch_assoc()) {
    $row['destinatarios'] = unserialize($row['destinatarios']);
    if (!empty($row['lido_por'])) {
        $row['lido_por'] = unserialize($row['lido_por']);
        if ($row['tipo'] == 'usuarios' && in_array($usuarioLogado['id'], $row['destinatarios']) &&  !in_array($usuarioLogado['id'], $row['lido_por'])) {
            $avisosDoUsuario[] = $row['id'];
        }
        if ($row['tipo'] == 'startups' && in_array($usuarioLogado['startup'], $row['destinatarios']) &&  !in_array($usuarioLogado['id'], $row['lido_por'])) {
            $avisosDoUsuario[] = $row['id'];
        }
    } else {
        if ($row['tipo'] == 'usuarios' && in_array($usuarioLogado['id'], $row['destinatarios'])) {
            $avisosDoUsuario[] = $row['id'];
        }
        if ($row['tipo'] == 'startups' && in_array($usuarioLogado['startup'], $row['destinatarios'])) {
            $avisosDoUsuario[] = $row['id'];
        }
    }
}

if (!empty($avisosDoUsuario)) {
    $idsAvisos = implode(',', array_fill(0, count($avisosDoUsuario), '?'));
    $buscarAvisosUsuario = $conn->prepare("
            SELECT a.*, CONCAT(u.nome, ' ', u.sobrenome) AS remetente_nome, u.imagemPerfil AS remetente_imagemPerfil
            FROM avisos AS a
            LEFT JOIN usuarios AS u ON a.remetente = u.id
            WHERE a.id IN ($idsAvisos)
        ");
    $tipos = str_repeat('i', count($avisosDoUsuario));
    $buscarAvisosUsuario->bind_param($tipos, ...$avisosDoUsuario);
    $buscarAvisosUsuario->execute();
    $resultadosAvisosUsuario = $buscarAvisosUsuario->get_result();
    $buscarAvisosUsuario->close();

    $avisosMenu = [];
    while ($row = $resultadosAvisosUsuario->fetch_assoc()) {
        $avisosMenu[] = $row;
    }
}
?>