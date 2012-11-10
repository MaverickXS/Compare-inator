<?php

function showSystemIcons($User){
    $sReturn = '';

    // Check PSN
    if (trim($User->psn_id . '') != '') {
        $sReturn .= '&nbsp;<img src="/img/psn.png" class="psn_toggle" data-user-key="' . $User->u_key . '" title="PSN - ' . $User->psn_id . '" />';
    }

    // Check Steam
    if (trim($User->steam_id . '') != '') {
        //$sReturn .= '&nbsp;<img src="/img/steam.png" class="steam_toggle" data-user-key="' . $User->u_key . '" title="Steam - ' . $User->steam_id . '" />';
    }

    // Check XBL
    if (trim($User->xbl_id . '') != '') {
        $sReturn .= '&nbsp;<img src="/img/xbl.png" class="xbl_toggle" data-user-key="' . $User->u_key . '" title="XBL - ' . $User->xbl_id . '" />';
    }

    return $sReturn;
}

?>