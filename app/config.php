<?php

/*VERSAO 2 23062021*/

define('PROGRESS_DLC','C:/Progress/OpenEdge/'); 
define('PROGRESS_CFG','progress.cfg'); 
define('PROGRESS_PF','C:/TRADESIS/PROGRESS/database/lebes/admcom.pf'); 
define('PROGRESS_TMP','C:/TRADESIS/PROGRESS/wrk/'); 
define('PROGRESS_PROPATH','C:/TRADESIS/LEBES/bsweb/app/,C:/TRADESIS/LEBES/bsweb/admcom/,'); 
define('PROGRESS_PROGRINICIAL','C:/TRADESIS/LEBES/bsweb/database/progress.p');

$progresscfg    = PROGRESS_CFG;
$dlc            = PROGRESS_DLC;
$tmp            = PROGRESS_TMP;
$pf             = PROGRESS_PF;
$propath        = PROGRESS_PROPATH;
$proginicial    = PROGRESS_PROGRINICIAL;


function defineConexaoProgress()
{
  
  return        array(    "progresscfg" => PROGRESS_CFG, 
                          "dlc"         => PROGRESS_DLC,
                          "pf"          => PROGRESS_PF, 
                          "tmp"         => PROGRESS_TMP,
                          "propath"     => PROGRESS_PROPATH,
                          "proginicial" => PROGRESS_PROGRINICIAL
   );

}


require (__DIR__ . "/../database/progress.php");
?>
