<?php
if (empty($sub_page)) {
    $quant_por_pagina = isset($_GET['quant_pg']) ? intval($_GET['quant_pg']) : 15;

    $pg_atual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;

    $calc_pg = ($pg_atual - 1) * $quant_por_pagina;

    $teste = "mais teste";
    $registros_total = $conn->prepare("SELECT COUNT(*) AS total FROM startups WHERE id != 1");
    $registros_total->execute();
    $total = $registros_total->get_result();
    $total = $total->fetch_assoc();
    $registros = $total['total'];

    $total_pg = ceil($registros / $quant_por_pagina);

    $buscar_startups = $conn->prepare("SELECT id, nome, imagem, ativo, responsavel, membros, cnpj  FROM startups WHERE id != 1 LIMIT ?, ?");
    $buscar_startups->bind_param("ii", $calc_pg, $quant_por_pagina);
    if (!$buscar_startups->execute()) {
        $teste = "falha";
    }
    $resultados = $buscar_startups->get_result();

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
}

if (!empty($sub_page) && $sub_page == 'minhastartup') {
}
