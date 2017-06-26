<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;

class HelloController extends ControllerBase {
	
	public function content($param) {

		
		$message = $this->t('Vous êtes sur la page Hello. Votre nom d\'utilisateur est %name, et voici le parametre de l\'url : %param', array('%name' => $this->currentUser()->getAccountName() , '%param' => $param
		));
		$build = array(
		'#markup' => $message,
		'#cache' => array(
			'keys' => ['hello_page'],
			'contexts' => ['user','url.path'],
			'tags' => ['user:'.$this->currentUser()->id()]
		),
		);

		return $build;
	}
}




