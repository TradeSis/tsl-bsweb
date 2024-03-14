<?php
 
 include("funcoes.inc");

 require_once("nusoapWS.php");

//$client = new nusoap_client('http://172.19.150.21:8080/conppwPadrao-war/WSAcordo?wsdl', 'wsdl');
$client = new nusoap_client('https://cyb11p01.toppen.com.br:8443/conppwPadrao-war/WSAcordo?wsdl', 'wsdl');


$err = $client->getError();
if ($err) {
 echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
 echo '<h2>Debug</h2>';
 echo '<pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
 exit();
}

       $param1         = getvar('param1');
//$param1 = '86658816034';



$dados = array(
  'cpfCnpj' => $param1 
  ); 
$result = $client->call('consultaAcordo', array('consultaAcordo' => $dados),'http://service.console.ppware.com.br/','',false,null,'document','literal');

$result = str_replace("&lt;","<",$result);
$result = str_replace("&gt;",">",$result);

echo array_complex_to_xml($result);

return;


?>
