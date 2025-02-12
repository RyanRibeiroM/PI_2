<?php
function logsLogin($log)
{
    $logArquivo = "_logs/log.txt";
    $logMensagem = "\n-----------------------------------------------\n";
    $logMensagem .= "[" . date("Y-m-d H:i:s") . "] " . $log . PHP_EOL;
    $logMensagem .= "------------------------------------------------";
    file_put_contents($logArquivo, $logMensagem, FILE_APPEND);
}

$rateLimit = 5;
$rateTimeLimit = 60;
$ip = $_SERVER['REMOTE_ADDR'];
$horaAtual = time();

if (isset($_SESSION["tempoEnvioForm"]) && $_SESSION["tempoEnvioForm"] > $horaAtual - $rateTimeLimit) {
    if ($_SESSION["contadorEnvioForm"] >= $rateLimit) {
        logsLogin("Muitas tentativas de envio feita pelo IP: $ip");
        $mensagem = '<div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon><div>';
        $mensagem .= 'Ops, Algo de errado!';
        $mensagem .= '<p class="fw-medium text-danger-600 text-sm mt-8">';
        $mensagem .= 'Muitas tentativas de envio do formulário, tente novamente em alguns segundos';
        $mensagem .= '</p></div></div><button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button></div></div>';
    } else {
        $_SESSION["contadorEnvioForm"]++;
    }
} else {
    $_SESSION["tempoEnvioForm"] = $horaAtual;
    $_SESSION["contadorEnvioForm"] = 1;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["entrar"])) {
    $tempoEnvioForm = time() - $_POST["tempoEnvioForm"];

    if (!hash_equals($_SESSION["token"], $_POST["token"])) {
        logsLogin("Token de acesso inválido para o IP: $ip");
        $mensagem = '<div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon><div>';
        $mensagem .= 'Ops, Algo de errado!';
        $mensagem .= '<p class="fw-medium text-danger-600 text-sm mt-8">';
        $mensagem .= 'Token de acesso inválido';
        $mensagem .= '</p></div></div><button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button></div></div>';
    } else if (!empty($_POST["campoNulo"])) {
        logsLogin("O campo nulo foi preenchido pelo IP: $ip");
    } else if ($tempoEnvioForm < 5) {
        logsLogin("Muitas tentativas de envio de formulário: $ip");
        $mensagem = '<div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon><div>';
        $mensagem .= 'Ops, Algo de errado!';
        $mensagem .= '<p class="fw-medium text-danger-600 text-sm mt-8">';
        $mensagem .= 'Muitas tentativas de login realizadas,<br>tente novamente em alguns segundos!';
        $mensagem .= '</p></div></div><button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button></div></div>';
    } else {
        $email = $_POST["email_usuario"];
        $senha = $_POST["senha"];
        $manterLogado = $_POST["manterLogado"] ?? false;

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["entrar"])) {
            $verificaLogin = $conn->prepare("SELECT id, senha FROM usuarios WHERE email = ? AND ativo = 1");
            $verificaLogin->bind_param("s", $email);
            $verificaLogin->execute();
            $resultadoVerificaLogin = $verificaLogin->get_result();
            $verificaLogin->close();

            if ($resultadoVerificaLogin->num_rows > 0) {
                $informacoesUsuario = $resultadoVerificaLogin->fetch_assoc();

                if (password_verify($senha, $informacoesUsuario['senha'])) {
                    if ($manterLogado) {
                        $_SESSION["manterLogado"] = true;
                    } else {
                        $_SESSION["manterLogado"] = false;
                    }

                    $_SESSION["idUsuario"] = $informacoesUsuario['id'];
                    unset($_SESSION["tempoEnvioForm"]);
                    unset($_SESSION["contadorEnvioForm"]);
                    header("Location: /home/");
                } else {
                    logsLogin("Senha inválida na tentativa de login do IP: $ip, email: $email");
                    $mensagem = '<div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon><div>';
                    $mensagem .= 'Ops, Algo de errado!';
                    $mensagem .= '<p class="fw-medium text-danger-600 text-sm mt-8">';
                    $mensagem .= 'Senha inválida';
                    $mensagem .= '</p></div></div><button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button></div></div>';
                }
            } else {
                logsLogin("Usuário inválido na tentativa de login do IP: $ip, email: $email");
                $mensagem = '<div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert"><div class="d-flex align-items-start justify-content-between text-lg"><div class="d-flex align-items-start gap-2"><iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon><div>';
                $mensagem .= 'Ops, Algo de errado!';
                $mensagem .= '<p class="fw-medium text-danger-600 text-sm mt-8">';
                $mensagem .= 'Usuário inválido ou inexistente';
                $mensagem .= '</p></div></div><button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button></div></div>';
            }
        }
    }
}

if (isset($_SESSION["manterLogado"]) && $_SESSION["manterLogado"] === true) {
    if (isset($_SESSION["tempoFinal"])) {
        $tempoAtual = time();
        $tempoInativo = $tempoAtual - $_SESSION["tempofinal"];
        $tempoLimite = 2592000;

        if ($tempoInativo > $tempoLimite) {
            session_unset();
            session_destroy();
            header("Location: /login");
        }
    }
} else {
    if (isset($_SESSION["tempoFinal"])) {
        $tempoAtual = time();
        $tempoInativo = $tempoAtual - $_SESSION["tempoFinal"];

        $tempoLimite = 86400;

        if ($tempoInativo > $tempoLimite) {
            session_unset();
            session_destroy();
            header("Location: /login");
        }
    }
}
$_SESSION["tempoFinal"] = time();
