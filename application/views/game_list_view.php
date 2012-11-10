        <h1>Game List</h1>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Game</th>
                </tr>
            </thead>
            <tbody>
                <? foreach($game_list->result() as $game){ ?>
                    <tr>
                        <td>
                            <? if ($game->trophies > 0){ ?><img src="/img/games/<?=$game->g_key;?>_psn.png" class="game_image" /><? } ?>
                            <? if ($game->achievements > 0){ ?><img src="/img/games/<?=$game->g_key;?>_xbl.png" class="game_image" /><? } ?>
                        </td>
                        <td><?=fixGameName($game);?></td>
                    </tr>
                <? } ?>
            </tbody>
        </table>