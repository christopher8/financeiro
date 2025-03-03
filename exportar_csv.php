<?php
include_once('config\functions.php');
$listarCompras = listarCompras($conn);





// Função para calcular as faturas
function calcularFaturas($primeira_fatura, $numero_parcelas, $valor_parcela) {
    $faturas = [];
    if (!empty($primeira_fatura)) {
        $data_inicio = DateTime::createFromFormat('Y-m', $primeira_fatura);
        if ($data_inicio instanceof DateTime) {
            for ($i = 0; $i < $numero_parcelas; $i++) {
                $data_parcela = clone $data_inicio;
                $data_parcela->modify("+$i month");
                $mes_parcela = $data_parcela->format('Y-m');
                $faturas[$mes_parcela] = $valor_parcela;
            }
        }
    }
    return $faturas;
}

// Obter os dados das compras usando a função listarCompras()
$compras = listarCompras($conn);

// Gerar os próximos 12 meses
$data_atual = new DateTime();
$proximos_meses = [];
for ($i = 0; $i < 12; $i++) {
    $mes = clone $data_atual;
    $mes->modify("+$i month");
    $proximos_meses[] = $mes->format('Y-m');
}

// Preparar os dados para o CSV
$dados_csv = [];

// Cabeçalho do CSV
$cabecalho = ['Comprador', 'Cartão Usado', 'Categoria', 'Produto'];
foreach ($proximos_meses as $mes) {
    $formatter = new IntlDateFormatter(
        'pt_BR',
        IntlDateFormatter::NONE,
        IntlDateFormatter::NONE,
        NULL,
        NULL,
        'MMM/yy'
    );
    $cabecalho[] = $formatter->format(DateTime::createFromFormat('Y-m', $mes));
}
$dados_csv[] = $cabecalho;

// Dados das compras
foreach ($compras as $compra) {
    $linha = [
        $compra['id_usuario'],
        $compra['id_cartao'],
        $compra['id_categoria'],
        $compra['item']
    ];

    // Calcular as faturas para esta compra
    $faturas = calcularFaturas(
        $compra['primeira_fatura'],
        $compra['numero_Parcelas'],
        $compra['valor_Parcela']
    );

    foreach ($proximos_meses as $mes) {
        $linha[] = isset($faturas[$mes]) ? "R$ " . number_format($faturas[$mes], 2, ',', '.') : '-';
    }

    $dados_csv[] = $linha;
}

// Gerar o arquivo CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="relatorio_financeiro.csv"');

$output = fopen('php://output', 'w');

// Escrever os dados no arquivo CSV
foreach ($dados_csv as $linha) {
    fputcsv($output, $linha, ';', '"', '\\'); // Adicionado o parâmetro $escape
}

fclose($output);
exit;
?>