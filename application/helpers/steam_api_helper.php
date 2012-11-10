<?php
// Requires that API Helper is loaded first!!
// API Key = 2BC45C48A6E5BC5C9D043C701E191EC3
// 76561197983971641 = MaverickXS SteamID
function getSteamUser($sUser){
    $oUser = getAPIResult('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=2BC45C48A6E5BC5C9D043C701E191EC3&steamids=' . $sUser);
    
    return $oUser;
}

/*
function getSteamGames($sUser){
    $oGames = getAPIResult('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=2BC45C48A6E5BC5C9D043C701E191EC3&steamids=' . $sUser);
    
    return $oGames;
}
*/
function getSteamAchievements($sUser, $sGame){
    $oTrophies = getAPIResult('http://api.steampowered.com/ISteamUserStats/GetPlayerAchievements/v0001/?appid=' . $sGame . '&key=2BC45C48A6E5BC5C9D043C701E191EC3&steamid=' . $sUser);
    
    return $oTrophies;
}
?>