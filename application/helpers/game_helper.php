<?php

function fixGameName($Game){
    $aReplaceList = array(
            '™'   => '&trade;',
            '®'    => '&reg;',
            '’'   => '\''
        );
    $sReturn = $Game->nm;

    foreach ($aReplaceList as $key => $value){
        $sReturn = str_replace($key, $value, $sReturn);
    }

    return $sReturn;
}

?>