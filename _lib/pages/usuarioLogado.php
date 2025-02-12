<?php
if (!empty($_SESSION['idUsuario'])) {
    $usuarioLogado = $conn->prepare("SELECT * FROM usuarios WHERE id = ? LIMIT 1");
    $usuarioLogado->bind_param('i', $_SESSION['idUsuario']);
    $usuarioLogado->execute();
    $resultados = $usuarioLogado->get_result();

    if ($resultados->num_rows > 0) {
        $usuarioLogado = $resultados->fetch_assoc();
        $_SESSION['nivelUsuarioLogado'] = $usuarioLogado['nivel'];
        $_SESSION['startupUsuarioLogado'] = $usuarioLogado['startup'];

        if (empty($usuarioLogado['nome']) || empty($usuarioLogado['email'])) {
            session_unset();
            session_destroy();
            header("Location: /");
        }
    } else {
        session_unset();
        session_destroy();
        header("Location: /");
    }
}
