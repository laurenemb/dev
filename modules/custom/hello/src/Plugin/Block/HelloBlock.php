<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a hello block.
 *
 * @Block(
 *	id = "hello_block",
 *	admin_label = @Translation("Hello!")
 * )
 */

class HelloBlock extends BlockBase {

	public function build(){

		$dateformatter = \Drupal::service('date.formatter');
		$date = $dateformatter->format(time(), 'custom', 'H:i s\s');

		$build = array('#markup' => $this->t('Bienvenue sur notre site. il est '.$date)
			);

		return $build;
	}

}

