<?php

/**
 * Função para converter o datetime do MySQL "Y-m-d hh:mm:ss" para melhor visualização "d/m/Y hh:mm"
 *
 * @param datetime $timestamp
 * @return date formatado para melhor visualização
 */
function converte_datetime($timestamp)
{
    $ar = explode(" ", $timestamp);
    $date = explode("-", $ar[0]);
    $time = explode(":", $ar[1]);
    $datetime = $date[2] . "/" . $date[1] . "/" . $date[0] . " " . $time[0] . ":" . $time[1];
    return $datetime;
}

/**
 * Método para otimizar o tempo na hora de printar um array/object
 *
 * @param array $data
 * @param bool $exit - se for true exita
 * @return void
 */
function p($data, $exit = 0)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    ($exit) ? die() : "";
}
/**
 * Método para otimizar o tempo na hora de printar a última query executada
 *
 * @param array $data
 * @param bool $exit - se for true exita
 * @return void
 */
function q($exit = 0)
{
    echo get_instance()->db->last_query();
    ($exit) ? die() : "";
}


/**
 * Pega qualquer CPF e CNPJ e formata
 * CPF: 000.000.000-00
 * CNPJ: 00.000.000/0000-00
 * @param string $cpf | $cnpj
 * @return string
 */
function formata_cpf_cnpj($cpf_cnpj)
{
    ## Retirando tudo que não for número.
    $cpf_cnpj = preg_replace("/[^0-9]/", "", $cpf_cnpj);
    $tipo_dado = NULL;
    if (strlen($cpf_cnpj) == 11) {
        $tipo_dado = "cpf";
    }
    if (strlen($cpf_cnpj) == 14) {
        $tipo_dado = "cnpj";
    }
    switch ($tipo_dado) {
        default:
            $cpf_cnpj_formatado = "CPF/CNPJ Inválido!";
            break;

        case "cpf":
            $bloco_1 = substr($cpf_cnpj, 0, 3);
            $bloco_2 = substr($cpf_cnpj, 3, 3);
            $bloco_3 = substr($cpf_cnpj, 6, 3);
            $dig_verificador = substr($cpf_cnpj, -2);
            $cpf_cnpj_formatado = $bloco_1 . "." . $bloco_2 . "." . $bloco_3 . "-" . $dig_verificador;
            break;

        case "cnpj":
            $bloco_1 = substr($cpf_cnpj, 0, 2);
            $bloco_2 = substr($cpf_cnpj, 2, 3);
            $bloco_3 = substr($cpf_cnpj, 5, 3);
            $bloco_4 = substr($cpf_cnpj, 8, 4);
            $digito_verificador = substr($cpf_cnpj, -2);
            $cpf_cnpj_formatado = $bloco_1 . "." . $bloco_2 . "." . $bloco_3 . "/" . $bloco_4 . "-" . $digito_verificador;
            break;
    }
    return $cpf_cnpj_formatado;
}
