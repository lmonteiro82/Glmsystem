<?php
// Start the session
session_start();

?>

<?php

include ("../../bd.php");

require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

// Instanciação do objeto Dompdf
$dompdf = new Dompdf(['enable_remote' => true]);

// HTML a ser convertido em PDF
$html = '<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
    </head>
    <style>
        #tbl {
            border-collapse: collapse;
            width: 100%;
        }

        td{
            text-align: center;
        }

        p{
            font-size: x-small;
        }

        table{
            width: 50%;
            margin: auto;
        }
    </style>
    <body>

        <div>
            <p><b>Glm System - Sistemas de Segurança, Unipessoal, Lda</b></p>
            <p>Rua Urbanização Quinta do Areeiro, 1005 2 º ESQ</p>
            <p>São João de Ver</p>
            <p>4520-615</p>
            <p>N/Contribuinte 513898727</p>
            <p>Telefone 966702326</p>
            <p>Email: geral@glmsystem.com / www.glmsystem.com</p><br><br><br><br><br>
        </div>

        <table id="tbl">
            <tr>
                <th style="width: 25%; border-bottom: 1px solid black; padding-bottom: 1%;">Produto</th>
                <th style="width: 25%; border-bottom: 1px solid black; padding-bottom: 1%;">Quantidade</th>
                <th style="width: 25%; border-bottom: 1px solid black; padding-bottom: 1%;">Preço</th>
                <th style="width: 25%; border-bottom: 1px solid black; padding-bottom: 1%;">Desconto (%)</th>
                <th style="width: 25%; border-bottom: 1px solid black; padding-bottom: 1%;">IVA (%)</th>
            </tr>';
            $sq="select * from orcamento where userid='" . $_SESSION["globaluserid"] . "'";
            $results = $ms->query($sq);
            while($row = $results->fetch_array()) {
                $html .= '<tr>
                    <td>' . $row["produto"] . '</td>
                    <td>' . $row["quantidade"] . '</td>
                    <td>' . $row["preco"] * $row["quantidade"] . '</td>
                    <td>' . $row["dsc"] . '</td>
                    <td>' . $row["iva"] . '</td>
                </tr>';
            }
            $html .= '<td>Mão de obra</td>';
            $html .= '<td>---</td>';
            $html .= '<td>' . $_SESSION["maoobra"] . '</td>';
            $html .= '<td>---</td>';
            $html .= '<td>---</td>';
        $html .= '</table>

        <table style="width: 100%; margin-top: 5%;">
            <tr>
                <td style="border: 1px solid black;">Valor sem IVA</td>
                <td style="border: 1px solid black;">' . number_format($_SESSION["totalpreco"], 2, ',', '.') . ' €</td>
            </tr>
            <tr>
                <td style="border: 1px solid black;">Valor do IVA</td>
                <td style="border: 1px solid black;">' . number_format($_SESSION["totaliva"], 2, ',', '.') . ' €</td>
            </tr>
            <tr>
                <td style="border: 1px solid black;"><b>Total (com IVA)</b></td>
                <td style="border: 1px solid black;"><b>' . number_format($_SESSION["total"] + $_SESSION["maoobra"], 2, ',', '.') . ' €</b></td>
            </tr>
        </table>

    </body>
</html>';

// Carrega o HTML no objeto Dompdf
$dompdf->loadHtml($html);

// Renderiza o PDF
$dompdf->render();

// Define o nome do arquivo PDF gerado
$nome_arquivo = 'Orçamento.pdf';

// Envia o arquivo PDF para download
$dompdf->stream($nome_arquivo, array('Attachment' => true));

$qr = "delete from orcamento where userid='" . $_SESSION["globaluserid"] . "'";
$ordem = $ms->query($qr);

$_SESSION["totalpreco"] = 0;
$_SESSION["totaliva"] = 0;
$_SESSION["total"] = 0;
$_SESSION["maoobra"] = 0;

?>