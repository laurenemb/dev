<?php

namespace Drupal\annonce\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Annonce entities.
 */
class AnnonceViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['annonce_history']['table']['group'] = t('Annonce history');
    $data['annonce_history']['table']['provider'] = 'Annonce';
    $data['annonce_history']['table']['base'] = array(
    	'field' => 'ahid',
    	'title' => t('annonce view date'),
	    'desc' => t('blablabla'),
	    'weight' => -100,
    );

    $data['annonce_history']['uid'] = array(
    	'title' => t('Annonce User  ID'),
	    'desc' => t('Annonce User  ID'),
	    'field' => array('id' => 'numeric'),
	    'sort' => array('id' => 'standard'),
	    'filter' => array('id' => 'numeric'),
	    'argument' => array('id' => 'numeric'),
	    'relationship' => array(
	    	'base' => 'user_field_data',
	    	'base field' => 'uid',
	    	'id' => 'standard',
	    	'label' => t('Annonce history UID -> User ID'),
	    ),
    );

    $data['annonce_history']['aid'] = array(
    	'title' => t('Annonce ID'),
	    'desc' => t('Annonce content ID'),
	    'field' => array('id' => 'numeric'),
	    'sort' => array('id' => 'standard'),
	    'filter' => array('id' => 'numeric'),
	    'argument' => array('id' => 'numeric'),
	    'relationship' => array(
	    	'base' => 'annonce_field_data',
	    	'base field' => 'uid',
	    	'id' => 'standard',
	    	'label' => t('Annonce history AID -> User ID'),
	    ),
    );

	 $data['annonce_history']['date'] = array(
	    'title' => t('annonce view date'),
	    'desc' => t('blablabla'),
	    'field' => array('id' => 'date'),
	    'sort' => array('id' => 'date'),
	    'filter' => array('id' => 'date'),
	  );

    return $data;
  }

}
