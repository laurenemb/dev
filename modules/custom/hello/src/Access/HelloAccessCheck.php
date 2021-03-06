<?php

namespace Drupal\hello\Access;

use Drupal\Core\Access\AccessCheckInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Access\AccessResult;


class HelloAccessCheck implements AccessCheckInterface {

	public function applies(Route $route) {
		return NULL;
	}

	public function access(Route $route, Request $request = NULL, AccountInterface $account) {
		$nbr_heure = $route->getRequirement('_hello_access');
		
		if ($account->isAnonymous()){
			return AccessResult::forbidden();
		}
		if ((REQUEST_TIME - $account->getAccount()->created > $nbr_heure * 3600)) {
		return AccessResult::allowed()->cachePerUser();
		}
		return AccessResult::forbidden();
	}
}