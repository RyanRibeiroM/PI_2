<?php
if (empty($sub_pagina)) {
    $buscar_mural = $conn->prepare("SELECT * FROM mural WHERE ativo = 1 ORDER BY id DESC");
    $buscar_mural->execute();
    $resultados = $buscar_mural->get_result();

    $murais = [];
    while ($row = $resultados->fetch_assoc()) {
        $row['imagens'] = unserialize($row['imagens']);
        $murais[] = $row;
    }
}
