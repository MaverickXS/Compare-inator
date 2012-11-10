<?php
function getImage($sURL, $sLocalFilePath){
    $oCURL = curl_init($sURL);
    curl_setopt($oCURL, CURLOPT_HEADER, 0);
    curl_setopt($oCURL, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($oCURL, CURLOPT_BINARYTRANSFER,1);
    $rawdata = curl_exec($oCURL);
    curl_close ($oCURL);

    if(file_exists($sLocalFilePath)){
        unlink($sLocalFilePath);
    }

    $oFS = fopen($sLocalFilePath, 'x');
    fwrite($oFS, $rawdata);
    fclose($oFS);
}

function getAPIResult($sURL){
	$oCURL = curl_init();
	curl_setopt($oCURL, CURLOPT_URL, $sURL);
	curl_setopt($oCURL, CURLOPT_HEADER, 0);
	curl_setopt($oCURL, CURLOPT_RETURNTRANSFER , TRUE);
	$result = curl_exec($oCURL);
	curl_close($oCURL);

    return json_decode($result);
}
?>