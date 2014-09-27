<?php

namespace byelsystems\boletophp;

// Utilizando DateTime da SPL
use \DateTime;

/**
 * Entrando no modo debug
 *
 * @var bool
 */
define('DEBUG', true);

// Habilitando display simples de erros
ini_set('display_errors', 1);
ini_set('html_errors', 0);

/**
 * Formato nativo de data pt-BR
 *
 * @var string
 */
define('DATA_FORMATO_NATIVO', 'd/m/Y');

/**
 * Formato nativo do PHP para utilização com funções do mesmo
 *
 * @var string
 */
define('DATA_FORMATO_EXTERNO', 'Y-m-d');

// Copiando conteúdo do $_GET original
$get = $_GET;

if (!isset($get['d']))
{
    $get['d'] = date(DATA_FORMATO_NATIVO);
}

$data = DateTime::createFromFormat(DATA_FORMATO_NATIVO, $get['d']);

/**
 * Falsa data de processamento da requisição, para geração de
 * timestamps
 *
 * @var string
 */
define('DATA_PROC', $data->format(DATA_FORMATO_EXTERNO));

// Sobrescrevendo algumas funções do PHP utilizadas amplamente no
// projeto para cáluclo de vencimentos e etc

// Intituito é avaliar facilmente qualquer alteração no código de
// barras introduzida por alterações externas

define('TIME_PROC', \strtotime(DATA_PROC));

/**
 * Sobrescrita da função date nativa do PHP para provimento de
 * timestamps estáticos.
 *
 * @return string
 */
function time()
{
    return TIME_PROC;
}
/**
 * Sobrescrita da função date nativa do PHP para provimento de
 * datas estáticas.
 *
 * @param string $format        
 * @param number $timestamp        
 */
function date($format, $timestamp = null)
{
    if ($timestamp == null)
    {
        return \date($format, TIME_PROC);
    }
    else
    {
        return \date($format, $timestamp);
    }
}

include 'index.php';