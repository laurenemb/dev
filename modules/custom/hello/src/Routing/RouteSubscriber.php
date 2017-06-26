<?php

namespace Drupal\hello\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

class RouteSubscriber extends RouteSubscriberBase {

	protected function alterRoutes(RouteCollection $collection) {

/**	    if ($route = $collection->get('system.modules_list')) {
	      //kint ($route);
	      //exit();
	      $route->setRequirements(array('_access', 'FALSE'));
	  	}

	  	if ($route = $collection->get('system.modules_uninstall')) {
	      $route->setRequirements(array('_access', 'FALSE'));
	  	}
*/	}

}