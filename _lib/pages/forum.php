<?php
if (!empty($sub_pagina) && $sub_pagina === "cadastrar") {
    $buscarStartups = $conn->prepare("SELECT id, nome FROM startups WHERE id != 1");
    $buscarStartups->execute();
    $resultados = $buscarStartups->get_result();
    $startups = [];

    while ($row = $resultados->fetch_assoc()) {
        $startups[] = $row;
    }
}
