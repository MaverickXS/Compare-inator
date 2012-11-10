<?php
// Requires that API Helper is loaded first!!
function getPSNUser($sUser){
    $oUser = getAPIResult('http://api.ps3heroes.com/api/hero/' . $sUser);
    
    return $oUser;
}

function getPSNGames($sUser){
    $oGames = getAPIResult('http://api.ps3heroes.com/api/hero/' . $sUser . '/games');
    
    return $oGames;
}

function getPSNTrophies($sUser, $sGame){
    $oTrophies = getAPIResult('http://api.ps3heroes.com/api/hero/' . $sUser . '/trophies/' . $sGame);
    
    return $oTrophies;
}

function getPSNPoints($sType){
    $sResult = 0;

    switch ($sType){
        case '1': // Bronze
            $sResult = 15;
            break;
        case '2': // Silver
            $sResult = 30;
            break;
        case '3': // Gold
            $sResult = 90;
            break;
        case '4': // Platinum
            $sResult = 180;
            break;
    }

    return $sResult;
}
?>