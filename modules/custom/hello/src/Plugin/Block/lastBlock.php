<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a hello block.
 *
 * @Block(
 *	id = "last_block",
 *	admin_label = @Translation("3 derniers articles")
 * )
 */

class lastBlock extends BlockBase {

	public function build(){

		$query = \Drupal::entityTypeManager()->getStorage('node')->getQuery();
		$query->condition('type','article');
		$nids = $query->range(0,3)->sort('created', 'desc')->execute();
		//kint($nids);

		// Charge les oeuds correspondants au résultat de la requête.
		$nodes = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($nids);
		//kint($nodes);
		// Construit un tableau de liens vers les noeuds
		$items = array();
		foreach($nodes as $node){
			$items[] = $node->toLink();
		}

		// Render arrays à afficher 
  		$list = array(
			'#theme' => 'item_list',
			'#items' => $items,
			'#cache' => array(
				'max-age' => '1',
			)
		);

  		return $list;

	}

}
