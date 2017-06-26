<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\BlockBase;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;


/**
 * Provides a hello block.
 *
 * @Block(
 *	id = "active_block",
 *	admin_label = @Translation("Sessions actives")
 * )
 */

class ActiveBlock extends BlockBase {

	public function build(){

		$database = \Drupal::database();

		$session_num = $database->select('sessions', 's')
							->countQuery()
							->execute()
							->fetchField();

		return array(
			'#markup' => $this->t('Il y a actuellement %session sessions actives.', 
					array('%session'=>$session_num)),
			'#cache' => array('key' =>['hello:sessions'],'max-age' => 100),
		);

	}

	protected function blockAccess(AccountInterface $account) {	  
	return AccessResult::allowedIfHasPermissions($account, array('access hello'));
	}
} 

