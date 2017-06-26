<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;

class NodeListController extends ControllerBase {
	
	public function content() {

		$memory_start = memory_get_usage();
		$start = microtime();

		//	\Drupal::service('entity.query');
		$query = $this->entityTypeManager()->getStorage('node')->getQuery();
		
		if ($nodetype) {
			$query->condition('type', $nodetype);
		}
		
		$nids = $query->pager('10')->execute();
		
		//kint($nids);

		$nodes = $this->entityTypeManager()->getStorage('node')->loadMultiple($nids);

		//kint($nodes);
		$items = array();
		foreach($nodes as $node){
			$items[] = $node->toLink();
		}

		//$items = array(1, 2, 3);

		$list = array(
			'#theme' => 'item_list',
			'#items' => $items,	
		);

		$pager = array(
			'#type' => 'pager',
		);

		$memory_end = memory_get_usage();
		$end = microtime();
		
		dpm($memory_end - $memory_start);
		dpm($end - $start);

		return array(
			'list' => $list,
			'pager' => $pager
		);

	}
}
