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
// | Desenv Boleto SICREDI: Rafael Azenha Aquini <rafael@tchesoft.com>    |
// |                        Marco Antonio Righi <marcorighi@tchesoft.com> |
// | Homologação e ajuste de algumas rotinas.                             |
// |                        Marcelo Belinato  <mbelinato@gmail.com>       |
// +----------------------------------------------------------------------+

namespace byelsystems\boletophp;

// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)     //

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 5;
$taxa_boleto = 2.95;
$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
$valor_cobrado = "2950,00"; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto = array(
    "inicio_nosso_numero" => date("y"),     // Ano da geração do título ex: 07 para 2007 
    "nosso_numero" => "13871",                 // Nosso numero (máx. 5 digitos) - Numero sequencial de controle.
    "numero_documento" => "27.030195.10",     // Num do pedido ou do documento
    "data_vencimento" => $data_venc, // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
    "data_documento" => date("d/m/Y"), // Data de emissão do Boleto
    "data_processamento" => date("d/m/Y"), // Data de processamento do boleto (opcional)
    "valor_boleto" => $valor_boleto,      // Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

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
    "aceite" => "N",         // N - remeter cobrança sem aceite do sacado  (cobranças não-registradas)
                                  // S - remeter cobrança apos aceite do sacado (cobranças registradas)
    "especie" => "R$",
    "especie_doc" => "A", // OS - Outros segundo manual para cedentes de cobrança SICREDI


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - SICREDI
    "agencia" => "1234",      // Num da agencia (4 digitos), sem Digito Verificador
    "conta" => "12345",      // Num da conta (5 digitos), sem Digito Verificador
    "conta_dv" => "6",      // Digito Verificador do Num da conta

// DADOS PERSONALIZADOS - SICREDI
    "posto" =>  "18",      // Código do posto da cooperativa de crédito
    "byte_idt" =>  "2",       // Byte de identificação do cedente do bloqueto utilizado para compor o nosso número.
                                  // 1 - Idtf emitente: Cooperativa | 2 a 9 - Idtf emitente: Cedente
    "carteira" => "A",   // Código da Carteira: A (Simples) 

// SEUS DADOS
    "identificacao" => "BoletoPhp - Código Aberto de Sistema de Boletos",
    "cpf_cnpj" => "",
    "endereco" => "Coloque o endereço da sua empresa aqui",
    "cidade_uf" => "Cidade / Estado",
    "cedente" => "Coloque a Razão Social da sua empresa aqui",
);

// NÃO ALTERAR!
include("include/funcoes_sicredi.php"); 

init($dadosboleto);

include("include/layout_sicredi.php");
