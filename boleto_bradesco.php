<?php
// +----------------------------------------------------------------------+
// | BoletoPhp - Versão Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo está disponível sob a Licença GPL disponível pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Você deve ter recebido uma cópia da GNU Public License junto com     |
// | esse pacote; se não, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colaborações de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do    |
// | PHPBoleto de João Prado Maia e Pablo Martins F. Costa                |
// |                                                                      |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto Bradesco: Ramon Soares                        |
// +----------------------------------------------------------------------+

namespace byelsystems\boletophp;

// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)    //

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 5;
$taxa_boleto = 2.95;
$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006";
$valor_cobrado = "2950,00"; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto = array(
    "nosso_numero" => "75896452",  // Nosso numero sem o DV - REGRA: Máximo de 11 caracteres!
    "numero_documento" => "75896452",    // Num do pedido ou do documento = Nosso numero
    "data_vencimento" => $data_venc, // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
    "data_documento" => date("d/m/Y"), // Data de emissão do Boleto
    "data_processamento" => date("d/m/Y"), // Data de processamento do boleto (opcional)
    "valor_boleto" => $valor_boleto,     // Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
    "sacado" => "Nome do seu Cliente",
    "endereco1" => "Endereço do seu Cliente",
    "endereco2" => "Cidade - Estado -  CEP: 00000-000",

// INFORMACOES PARA O CLIENTE
    "demonstrativo1" => "Pagamento de Compra na Loja Nonononono",
    "demonstrativo2" => "Mensalidade referente a nonon nonooon nononon<br>Taxa bancária - R$ ".number_format($taxa_boleto, 2, ',', ''),
    "demonstrativo3" => "BoletoPhp - http://www.boletophp.com.br",
    "instrucoes1" => "- Sr. Caixa, cobrar multa de 2% após o vencimento",
    "instrucoes2" => "- Receber até 10 dias após o vencimento",
    "instrucoes3" => "- Em caso de dúvidas entre em contato conosco: xxxx@xxxx.com.br",
    "instrucoes4" => "&nbsp; Emitido pelo sistema Projeto BoletoPhp - www.boletophp.com.br",

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
    "quantidade" => "001",
    "valor_unitario" => $valor_boleto,
    "aceite" => "",
    "especie" => "R$",
    "especie_doc" => "DS",


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - Bradesco
    "agencia" => "1100", // Num da agencia, sem digito
    "agencia_dv" => "0", // Digito do Num da agencia
    "conta" => "0102003",     // Num da conta, sem digito
    "conta_dv" => "4",     // Digito do Num da conta

// DADOS PERSONALIZADOS - Bradesco
    "conta_cedente" => "0102003", // ContaCedente do Cliente, sem digito (Somente Números)
    "conta_cedente_dv" => "4", // Digito da ContaCedente do Cliente
    "carteira" => "06",  // Código da Carteira: pode ser 06 ou 03

// SEUS DADOS
    "identificacao" => "BoletoPhp - Código Aberto de Sistema de Boletos",
    "cpf_cnpj" => "",
    "endereco" => "Coloque o endereço da sua empresa aqui",
    "cidade_uf" => "Cidade / Estado",
    "cedente" => "Coloque a Razão Social da sua empresa aqui",
);

// NÃO ALTERAR!
include("include/funcoes_bradesco.php");

$boleto = new BoletoBradesco();
$boleto->init($dadosboleto);

include("include/layout_bradesco.php");