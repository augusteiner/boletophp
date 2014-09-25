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
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
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

/**
 * Boleto Sofisa para carteira 121
 *
 * @package     BoletoPhp
 * @author      Diego M. Agudo ( diego@agudo.eti.br )
 */


// DADOS DO BOLETO PARA O SEU CLIENTE
$taxa_boleto                        = 0;
$data_venc                          = $data_vencimento;
$valor_cobrado                      = $valor_boleto_aux;
$valor_cobrado                      = str_replace(",", ".",$valor_cobrado);
$valor_boleto                       = number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto = array(
    "nosso_numero" =>  $nosso_numero,                // Nosso numero DV - REGRA: Máximo de 10 caracteres!
    "numero_documento" =>  $dadosboleto["nosso_numero"], // Num do pedido ou do documento = Nosso numero
    "data_vencimento" =>  $data_venc,                   // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA

    "data_documento" =>  $data_geracao,    // Data de processamento do boleto (opcional)
    "data_processamento" =>  $data_geracao,    // Data de processamento do boleto (opcional)

    "valor_boleto" =>  $valor_boleto,    // Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

    // DADOS DO SEU CLIENTE
    "sacado" =>  $sacado_nome,
    "endereco1" =>  $sacado_endereco,
    "endereco2" =>  $sacado_cidade_uf_cep,

    // INFORMACOES PARA O CLIENTE

    "demonstrativo1" =>  "",
    "demonstrativo2" =>  "",
    "demonstrativo3" =>  "",

    "instrucoes1" =>  "- Sr. Caixa, não receber após o vencimento.",
    # "instrucoes2" =>  "- Receber até 10 dias após o vencimento",
    # "instrucoes3" =>  "- Em caso de dúvidas entre em contato conosco: xxxx@xxxx.com.br",
    # "instrucoes4" =>  "&nbsp; Emitido pelo sistema Projeto BoletoPhp - www.boletophp.com.br",

    // DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
    "quantidade" =>  "001",
    "valor_unitario" =>  $valor_boleto,
    "aceite" =>  "",
    "especie" =>  "R$",
    "especie_doc" =>  "REC",


    // ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


    // DADOS DA SUA CONTA
    "agencia" =>  $agencia,     // Num da agencia, sem digito
    "agencia_dv" =>  $agencia_dv,  // Digito do Num da agencia
    "conta" =>  $conta,       // Num da conta, sem digito
    "conta_dv" =>  $conta_dv,    // Digito do Num da conta

    // DADOS PERSONALIZADOS
    "conta_cedente" =>  $dadosboleto["conta"],    // ContaCedente do Cliente, sem digito (Somente Números)
    "conta_cedente_dv" =>  $dadosboleto["conta_dv"], // Digito da ContaCedente do Cliente
    "carteira" =>  "121",                    // Código da Carteira: 121

    // SEUS DADOS
    "identificacao" =>  $cedente_identificacao,
    "cpf_cnpj" =>  $cedente_cnpj,
    "endereco" =>  $cedente_endereco,
    "cidade_uf" =>  $cedente_cidade_uf,
    "cedente" =>  $cedente_razao_soscial,
);

// NÃO ALTERAR!
include("include/funcoes_sofisa.php"); 

init($dadosboleto);

include("include/layout_sofisa.php");
