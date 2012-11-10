<div class="btn-group">
    <? if (trim($user['psn_id'] . '') != '') { ?><button id="update_psn" class="btn" onclick="fncUpdateMyPSN();"><img src="/img/psn.png" /> Update PSN</button><? } ?>
    <? if (trim($user['xbl_id'] . '') != '') { ?><button id="update_xbl" class="btn" onclick="fncUpdateMyXBL();"><img src="/img/xbl.png" /> Update XBL</button><? } ?>
    <? if ((trim($user['psn_id'] . '') != '') && (trim($user['psn_id'] . '') != '')) { ?><button id="update_xbl" class="btn" onclick="fncUpdateMyXBL();"><img src="/img/favicon.ico" /> Update All</button><? } ?>
</div>