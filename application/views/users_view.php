        <? $sAltClass = ''; ?>
        <form method="post" action="">
            <dl>
                <? foreach($user_list->result() as $user){ ?>
                    <label<? if ($sAltClass!=''){ ?> class="<?=$sAltClass;?>"<? } ?>>
                        <dt><input type="checkbox" name="compare" value="<?=$user->u_key;?>" class="checkbox" />&nbsp;<a href="/users/<?=$user->username;?>"><?=$user->username;?></a><?=showSystemIcons($user);?></dt>
                            <dd id="psn_<?=$user->u_key;?>" class="span3 well" style="display: none;">
                                <img src="/img/users/<?=$user->u_key;?>_psn.png" class="avatar_sml" onerror="fncHandleMissing(this);" />
                                <strong><?=$user->psn_id;?></strong> - <?=$user->psn_platinum + $user->psn_gold + $user->psn_silver + $user->psn_bronze;?><br/>
                                <img src="/img/psn_trophy_level.png" class="mini_icon" /> <?=$user->psn_level;?> <meter value="<?=$user->psn_progress;?>" min="0" max="100" low="33" high="66" optimum="100" title="<?=$user->psn_progress;?>%"><?=$user->psn_progress;?>%</meter> <?=$user->psn_progress;?>%<br/>
                                <img src="/img/psn_trophy_platinum.png" class="mini_icon" /> <?=$user->psn_platinum;?> <img src="/img/psn_trophy_gold.png" class="mini_icon" /> <?=$user->psn_gold;?> <img src="/img/psn_trophy_silver.png" class="mini_icon" /> <?=$user->psn_silver;?> <img src="/img/psn_trophy_bronze.png" class="mini_icon" /> <?=$user->psn_bronze;?><br/>
                            </dd>
                            <dd id="steam_<?=$user->u_key;?>" class="span3 well" style="display: none;">
                                <img src="/img/users/<?=$user->u_key;?>_steam.png" class="avatar_sml" onerror="fncHandleMissing(this);" />
                                <strong><?=$user->steam_id;?></strong><br/>
                                Achievements: <?=$user->steam_achievements;?>
                            </dd>
                            <dd id="xbl_<?=$user->u_key;?>" class="span3 well" style="display: none;">
                                <img src="/img/users/<?=$user->u_key;?>_xbl.png" class="avatar_sml" onerror="fncHandleMissing(this);" />
                                <strong><?=$user->xbl_id;?></strong><br/>
                                <img src="/img/xbl_gamerscore.png" class="mini_icon" /> <?=$user->xbl_gamer_score;?> <img src="/img/xbl_achievements.png" class="mini_icon" /> <?=$user->xbl_achievements;?>
                            </dd>
                    </label>
                    <?
                    if ($sAltClass==''){
                        $sAltClass = 'alt';
                    } else {
                        $sAltClass = '';
                    }
                }
                ?>
                <dt><button type="submit" id="compare_btn" class="btn" onclick="" disabled="disabled">Compare</button></dt>
            </dl>
        </form>
