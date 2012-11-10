<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Load_Data extends CI_Controller {
	private $data = array();

	public function __construct(){
        parent::__construct();

		if ($ck = get_cookie('compareinator_session')){
			$this->authenticinator->check_cookie($ck);
		}
		
		$this->data['admin']		= false;
		$this->data['user']			= $this->session->userdata;
		$this->data['logged_in']	= $this->session->userdata('logged_in');
		if (isset($this->data['user']['is_admin'])){
			if ($this->data['user']['is_admin']){
				$this->data['admin'] = true;
			}
		}

		$this->data['active_link']  = 'load';
		$this->data['page_title']   = '';
	}

	public function index(){
        // Load Helpers
        $this->load->helper('api');
        $this->load->helper('psnhero_api');
        $this->load->helper('xbl_api');

        // Load Models
		$this->load->model('Users');
		$this->load->model('Games');
		$this->load->model('Trophies');

        // Update PSN Information (From PS3Heroes.com)
        $Users = $this->Users->get_psn_users();
        foreach ($Users->result() as $user){
            $this->update_psn($user);
        }

        unset($Users);

        // Update XBL Information (From XboxAPI.com)
        $Users = $this->Users->get_xbl_users();
        foreach ($Users->result() as $user){
            $this->update_xbl($user);
        }

        unset($Users);

        // Load views
        $this->load->view('template_top', $this->data);
		$this->load->view('load_data_view', $this->data);
        $this->load->view('template_bot', $this->data);
	}

    private function update_psn($user){
        // Update the user's PSN Data 
        $oUser = getPSNUser($user->psn_id);
        $user_last_updated = new DateTime($user->last_updated);

        unset($user_post_data);
        $user_post_data = array(
            'psn_level'         => $oUser->level,
            'psn_progress'      => $oUser->progress,
            'psn_platinum'      => $oUser->trophies->platinum,
            'psn_gold'          => $oUser->trophies->gold,
            'psn_silver'        => $oUser->trophies->silver,
            'psn_bronze'        => $oUser->trophies->bronze,
            'psn_game_count'    => $oUser->game_count,
            'last_updated'      => date('Y-m-d H:i:s')
        );
        $this->Users->update_user($user->u_key, $user_post_data);

        // Need to refresh the user Avatar
        getImage(str_ireplace('_m.png', '_l.png', $oUser->avatar), '/var/www/compare-inator.com/img/users/' . $user->u_key . '_psn.png');
        
        // Get a list of games this user has played and use it to build our game database.
        $oGames = getPSNGames($user->psn_id);
        foreach ($oGames as $Game){
            unset($game_post_data);
            unset($aGameResult);
            unset($oTrophies);

            $game_post_data = array(
                'nm'        => $Game->name,
                'trophies'  => $Game->trophies,
                'slug'      => $Game->id
            );
            $aGameResult = $this->Games->insert_update_game($game_post_data);
            $game_last_updated = new DateTime($Game->lastTrophy);

            // Grab the game Image
            if ($aGameResult[1]=='insert'){
                getImage($Game->img, '/var/www/compare-inator.com/img/games/' . $aGameResult[0] . '_psn.png');
            }
            
            if ($user_last_updated < $game_last_updated){
                $oTrophies = getPSNTrophies($user->psn_id, $Game->id);
                foreach ($oTrophies as $Trophy){
                    unset($trophy_post_data);
                    unset($aTrophyResult);

                    $trophy_post_data = array(
                        'trophy'        => $Trophy->name,
                        'ds'            => $Trophy->description,
                        'g_id'          => $aGameResult[0],
                        'psn_is_hidden' => $Trophy->is_hidden,
                        'psn_weight'    => getPSNPoints($Trophy->value)
                    );
                    $aTrophyResult = $this->Trophies->insert_update_trophy($trophy_post_data);

                    // Grab the trophy Image
                    if ($aTrophyResult[1]=='insert'){
                        getImage($Trophy->img, '/var/www/compare-inator.com/img/trophies/' . $aTrophyResult[0] . '_psn.png');
                    }

                    $SetOnUser = $this->Trophies->set_earned_trophy($aTrophyResult[0], $user->u_key, 'psn', $Trophy->earned);
                }
            }
        }
    }

    private function update_xbl($user){
        // Update the user's XBL Data 
        $oUser = getXBLUser($user->xbl_id);
        $user_last_updated = new DateTime($user->last_updated);

        unset($user_post_data);
        $user_post_data = array(
            'xbl_gamer_score'   => $oUser->Player->Gamerscore,
            'last_updated'      => date('Y-m-d H:i:s')
        );
        $this->Users->update_user($user->u_key, $user_post_data);

        // Need to refresh the user Avatar
        getImage($oUser->Player->Avatar->Gamerpic->Large, '/var/www/compare-inator.com/img/users/' . $user->u_key . '_xbl.png');
        getImage($oUser->Player->Avatar->Body, '/var/www/compare-inator.com/img/users/' . $user->u_key . '_xbl_body.png');
        
        // Get a list of games this user has played and use it to build our game database.
        $oGames = getXBLGames($user->xbl_id);
        if (!empty($oGames) && !is_null($oGames)){
            foreach ($oGames->Games as $Game){
                unset($game_post_data);
                unset($aGameResult);
                unset($oTrophies);

                if (htmlentities($Game->Name)!=''){
                    $game_post_data = array(
                        'nm'            => $Game->Name,
                        'achievements'  => $Game->PossibleAchievements,
                        'slug'          => $Game->ID
                    );
                    $aGameResult = $this->Games->insert_update_game($game_post_data);
                    $game_last_updated = new DateTime(date('Y-m-d H:i:s', intval($Game->Progress->LastPlayed)));

                    // Grab the game Image
                    getImage($Game->BoxArt->Large, '/var/www/compare-inator.com/img/games/' . $aGameResult[0] . '_xbl.png');
                    
                    if ($user_last_updated < $game_last_updated){
                        $oTrophies = getXBLAchievements($user->xbl_id, $Game->ID);
                        foreach ($oTrophies->Achievements as $Trophy){
                            unset($trophy_post_data);
                            unset($aTrophyResult);

                            $trophy_post_data = array(
                                'trophy'        => $Trophy->Name,
                                'ds'            => $Trophy->Description,
                                'g_id'          => $aGameResult[0],
                                'xbl_is_hidden' => $Trophy->IsHidden,
                                'xbl_weight'    => $Trophy->Score
                            );
                            $aTrophyResult = $this->Trophies->insert_update_trophy($trophy_post_data);

                            // Grab the trophy Image
                            if ($aTrophyResult[1]=='insert'){
                                getImage($Trophy->TileUrl, '/var/www/compare-inator.com/img/trophies/' . $aTrophyResult[0] . '_xbl.png');
                            }

                            $SetOnUser = $this->Trophies->set_earned_trophy($aTrophyResult[0], $user->u_key, 'xbl', date('Y-m-d H:i:s', intval($Trophy->EarnedOn)));
                        }
                    }
                }
            }
        }
    }
}
?>