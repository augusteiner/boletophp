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
// | Desenvolvimento Boleto CEF SIGCB: Davi Nunes Camargo                 |
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
// Composição Nosso Numero - CEF SIGCB
    "nosso_numero1" => "000", // tamanho 3
    "nosso_numero_const1" => "2", //constanto 1 , 1=registrada , 2=sem registro
    "nosso_numero2" => "000", // tamanho 3
    "nosso_numero_const2" => "4", //constanto 2 , 4=emitido pelo proprio cliente
    "nosso_numero3" => "000000019", // tamanho 9


    "numero_documento" => "27.030195.10",    // Num do pedido ou do documento
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

// INSTRUÇÕES PARA O CAIXA
    "instrucoes1" => "- Sr. Caixa, cobrar multa de 2% após o vencimento",
    "instrucoes2" => "- Receber até 10 dias após o vencimento",
    "instrucoes3" => "- Em caso de dúvidas entre em contato conosco: xxxx@xxxx.com.br",
    "instrucoes4" => "&nbsp; Emitido pelo sistema Projeto BoletoPhp - www.boletophp.com.br",

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
    "quantidade" => "",
    "valor_unitario" => "",
    "aceite" => "",        
    "especie" => "R$",
    "especie_doc" => "",


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - CEF
    "agencia" => "1234", // Num da agencia, sem digito
    "conta" => "123",     // Num da conta, sem digito
    "conta_dv" => "0",     // Digito do Num da conta

// DADOS PERSONALIZADOS - CEF
    "conta_cedente" => "123456", // Código Cedente do Cliente, com 6 digitos (Somente Números)
    "carteira" => "SR",  // Código da Carteira: pode ser SR (Sem Registro) ou CR (Com Registro) - (Confirmar com gerente qual usar)

// SEUS DADOS
    "identificacao" => "BoletoPhp - Código Aberto de Sistema de Boletos",
    "cpf_cnpj" => "",
    "endereco" => "Coloque o endereço da sua empresa aqui",
    "cidade_uf" => "Cidade / Estado",
    "cedente" => "Coloque a Razão Social da sua empresa aqui",
);

// NÃO ALTERAR!
include("include/funcoes_cef_sigcb.php"); 

init($dadosboleto);

include("include/layout_cef.php");
