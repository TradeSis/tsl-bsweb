<?php
        /**
         */
        //include "/u/bsweb/progr/php/progress.php";


        class p2k extends progress
        {
                var $ws = "p2k"; // Letra Minuscula por causa do progress

                function executarprogress($acao,$novaentrada)
                {
                        $log_datahora_ini = date("dmYHis");
                        $time_start = microtime(true);

                        $log_hostname     = gethostname();
                        $log_versao = "00";
                        $log_acao   = $acao;
                        
                        $x = str_replace("ABRE","<",$entrada);
                        $x = str_replace("FECHA",">",$x);

                        $original = $x;
                        $entrada = $x;

                        $arqlog  = "/u/bsweb/log/p2k".date("d").date("m").date("Y").".log";
                        $arquivo = fopen($arqlog,"a");
                        fwrite($arquivo,"XML\n");
                        fwrite($arquivo,$novaentrada);
                        fclose($arquivo);

                        $arqestatistica = "/u/bsweb/log/p2k_estatistica_".date("dmY").".log";
                        
                        $xml = simplexml_load_string(str_replace("&","&amp;",$entrada));
                        // $entrada)); // PHP5
                        //$xml = simplexml_load_string($entrada);

                        $xml = $novaentrada;
                        $xml = str_replace("!", " ", $xml);

                        $log_filial = $xml["codigo_filial"];
                        $log_pdv    = $xml["numero_pdv"];

                        $arquivo = fopen($arqlog,"a");
                        fwrite($arquivo,"\nLEU XML".$xml."\n");
                        fclose($arquivo);
                        
                        $usuario = $xml->controle->loja;
                        $senha   = $xml->controle->senha;
                        
                        if ("$acao" == "ConsultaCliente") {
                                $parametros = "<ConsultaCliente>";
                                $parametros .= arrayparaxml($xml);
                                $parametros = $parametros."</ConsultaCliente>";
                        }        

                        if ("$acao" == "AtualizacaoDadosCliente") {

                                $parametros = "<AtualizacaoDadosCliente>".arrayparaxml($xml)."</AtualizacaoDadosCliente>";

                        }

                        if ("$acao" == "BuscaDadosContratoNf") {

                                $parametros = "<BuscaDadosContratoNf>".array_complex_to_xml($xml)."</BuscaDadosContratoNf>";

                        }
                        if ("$acao" == "EfetivaVenda") {

                                $parametros = "<EfetivaVenda>".array_complex_to_xml($xml)."</EfetivaVenda>";

                        }
                        if ("$acao" == "ConsultaParcelas") {

                                $parametros = "<ConsultaParcelas>".arrayparaxml($xml)."</ConsultaParcelas>";

                        }
                        if ("$acao" == "EfetivaPagamentoPrestacao") {

                                $parametros = "<EfetivaPagamentoPrestacao>".arrayparaxml($xml)."</EfetivaPagamentoPrestacao>";

                        }
                        if ("$acao" == "BuscaDadosClienteNome") {

                                $parametros = "<BuscaDadosClienteNome>".arrayparaxml($xml)."</BuscaDadosClienteNome>";

                        }
                        if ("$acao" == "CancelamentoCrediario") {

                                $parametros = "<CancelamentoCrediario>".arrayparaxml($xml)."</CancelamentoCrediario>";

                        }
                        if ("$acao" == "BuscaSenhaToken") {

                                $parametros = "<BuscaSenhaToken>".arrayparaxml($xml)."</BuscaSenhaToken>";

                        }
                        if ("$acao" == "DataFuturaPagamentoPrestacao") {

                                $parametros = "<DataFuturaPagamentoPrestacao>".array_complex_to_xml($xml)."</DataFuturaPagamentoPrestacao>";

                        
                        }
                        if ("$acao" == "EfetivaPagamentoBonus") {

                                $parametros = "<EfetivaPagamentoBonus>".arrayparaxml($xml)."</EfetivaPagamentoBonus>";

                        }
                        if ("$acao" == "CancelamentoPagamentoPrestacao") {

                                $parametros = "<CancelamentoPagamentoPrestacao>".arrayparaxml($xml)."</CancelamentoPagamentoPrestacao>";

                        }

                        if ("$acao" == "ConsultaSPC") {
                            $parametros = "<ConsultaSPC>".arrayparaxml($xml)."</ConsultaSPC>"; }

                        if ("$acao" == "ConsultaProdutosFinanceiros") {
                            $parametros = "<ConsultaProdutosFinanceiros>".arrayparaxml($xml)."</ConsultaProdutosFinanceiros>"; }

                        if ("$acao" == "SimularTransacaodeCredito") {
                            $parametros = "<SimularTransacaodeCredito>".arrayparaxml($xml)."</SimularTransacaodeCredito>"; }

                        if ("$acao" == "AutorizarEmprestimo") {
                            $parametros = "<AutorizarEmprestimo>".array_complex_to_xml($xml)."</AutorizarEmprestimo>"; }

                        if ("$acao" == "EfetivaEmprestimo") {
                            $parametros = "<EfetivaEmprestimo>".array_complex_to_xml($xml)."</EfetivaEmprestimo>"; }

                        if ("$acao" == "ConsultaEstoque") {
                            $parametros = "<ConsultaEstoque>";
                            $parametros .= arrayparaxml($xml);
                            $parametros = $parametros."</ConsultaEstoque>";
                        }

                        if ("$acao" == "ConsultaImei") {
                           $parametros = "<ConsultaImei>".arrayparaxml($xml)."</ConsultaImei>"; }

                        if ("$acao" == "MargemDesconto") {
                           $parametros = "<MargemDesconto>".arrayparaxml($xml)."</MargemDesconto>"; }

                        $entrada = "<?xml version='1.0' encoding='UTF-8' ?><conteudo><controle></controle>$parametros</conteudo>";

                        $arquivo = fopen($arqlog,"a");
                        fwrite($arquivo,"\nXML ENTRADA".$entrada."\n");
                        fclose($arquivo);
                        
                        include "config.php";
                        $saida = "xml";

                        $this->progress($dlc,$pf,$propath,$progresscfg);
                        $this->parametro = "ws!acao!entrada";  
                        $this->parametros = $this->ws . "!" . $acao . "!" . $entrada; 
                        
                        $log_datahora_progress_ini = date("dmYHis");
                        $this->executa($proginicial);
                        $log_datahora_progress_fim = date("dmYHis");


                        $arquivo = fopen($arqlog,"a");
                        fwrite($arquivo,"EXECUTOU PROGRESS\n");
                        fclose($arquivo);
 
                        $arquivo = fopen($arqlog,"a");
                        fwrite($arquivo,"arquivo retorno\n");
                        fwrite($arquivo,$this->progress."\n");
                        fclose($arquivo);

                        $arquivo = fopen("/u/bsweb/progr/retorno.xml","w");
                        fwrite($arquivo,$this->progress."\n");
                        fclose($arquivo);
 
// $texto = htmlspecialchars_decode($this->progress);

function tirarAcento($frase){

$search =  explode(",","ç,æ,œ  ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,ã,Ã,Ç,Á,É,Í,Ó,Ú,À,È,Ì,Ò,Ù,Ä,Ë,Ï,Ö,Ü,Ÿ,Â,Ê,Î,Ô,Û,Å,E,I,Ø,U,&");
$replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,a,A,C,A,E,I,O,U,A,E,I,O,U,A,E,I,O,U,Y,A,E,I,O,U,A,E,I,O,U,E");

$frase = str_replace($search, $replace, $frase);

return $frase;
}

 $texto = htmlspecialchars_decode(tirarAcento($this->progress));

                         $arqlog  = "/u/bsweb/log/p2k".date("d").date("m").date("Y").".log";
                         $arquivo = fopen($arqlog,"a");
                         fwrite($arquivo,"SEM ACENTOS\n");
                         fwrite($arquivo,$texto."\n");
                         fclose($arquivo);

    $xml = simplexml_load_string($texto);

//    $xml = simplexml_load_string(str_replace("&","&amp;",$this->progress));

$array = json_decode(json_encode((array) $xml), 1);
$array = array($xml->getName() => $array);

                         $arquivo = fopen($arqlog,"a");
                         fwrite($arquivo,"retornando\n");
                         fwrite($arquivo,$array."\n");
                         fclose($arquivo);

                        $log_datahora_fim = date("dmYHis");
                        $time_end = microtime(true);

                        $execution_time = $time_end - $time_start;


                         $arquivo = fopen($arqestatistica,"a");
                         fwrite($arquivo,$log_datahora_ini.";");
                         fwrite($arquivo,$log_datahora_fim.";");
                         fwrite($arquivo,$log_hostname.";");
                         fwrite($arquivo,$log_versao.";");
                         fwrite($arquivo,$log_acao.";");
                         fwrite($arquivo,$log_filial.";");
                         fwrite($arquivo,$log_pdv.";");
                         fwrite($arquivo,$log_datahora_progress_ini.";");
                         fwrite($arquivo,$log_datahora_progress_fim.";");
                         fwrite($arquivo,$execution_time."\n");

                         fclose($arquivo);



return $array;

function XML2Array(SimpleXMLElement $parent)
{
    $array = array();

    foreach ($parent as $name => $element) {
        ($node = & $array[$name])
            && (1 === count($node) ? $node = array($node) : 1)
            && $node = & $node[];

        $node = $element->count() ? XML2Array($element) : trim($element);
    }

    return $array;
}

$array = XML2Array($xml);
$array = array($xml->getName() => $array);


$xml_array = unserialize(serialize(json_decode(json_encode((array) $xml), 1)));

                        return $array; 
                        //return $this->progress;
                }
                
        }
?>
