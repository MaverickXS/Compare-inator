<?php
// Requires that API Helper is loaded first!!
function getXBLUser($sUser){
    $oUser = getAPIResult('https://xboxapi.com/profile/' . $sUser);
    
    return $oUser;
}

function getXBLGames($sUser){
    $oGames = getAPIResult('https://xboxapi.com/games/' . $sUser);
    
    return $oGames;
}

function getXBLAchievements($sUser, $sGame){
    $oTrophies = getAPIResult('https://xboxapi.com/achievements/' . $sGame . '/' . $sUser);
    
    return $oTrophies;
}
?>