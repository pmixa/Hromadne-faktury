<?php

define('ARES','http://wwwinfo.mfcr.cz/cgi-bin/ares/darv_bas.cgi?ico=');
$ico = intval($_REQUEST['ic']);
$file = @file_get_contents(ARES.$ico);
if ($file) $xml = @simplexml_load_string($file);
$a = array();
if ($xml) {
 $ns = $xml->getDocNamespaces();
 $data = $xml->children($ns['are']);
 $el = $data->children($ns['D'])->VBAS;
 if (strval($el->ICO) == $ico) {
  $a['ico'] 	= strval($el->ICO);
  $a['dic'] 	= strval($el->DIC);
  $a['firma'] 	= strval($el->OF);
  $a['ulice']    = strval($el->AA->NU); 
        if (!empty($el->AA->CO) OR !empty($el->AA->CD)) { 
            // detekování popisného a orientačního čísla 
            $a['ulice'] .= " "; 
            if (!empty($el->AA->CD)) $a['ulice'] .= strval($el->AA->CD); 
            if (!empty($el->AA->CO) AND !empty($el->AA->CD)) $a['ulice'] .= "/"; 
            if (!empty($el->AA->CO)) $a['ulice'] .= strval($el->AA->CO); 
        } 
  $a['mesto']	= strval($el->AA->N);
  $a['psc']	= strval($el->AA->PSC);
  $a['stav'] 	= 'ok';
 } else
  $a['stav'] 	= 'IČ firmy nebylo nalezeno';
} else
 $a['stav'] 	= 'Databáze ARES není dostupná';
echo json_encode($a);
