<?php

namespace Drupal\annonce\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\HttpKernel\KernelEvents;
use Drupal\Core\Routing\RouteMatchInterface;

/**
 * Class AnnonceEventDispatcher.
 *
 * @package Drupal\annonce
 */
class AnnonceEventDispatcher implements EventSubscriberInterface {

  /**
   * Drupal\Core\Session\AccountProxy definition.
   *
   * @var \Drupal\Core\Session\AccountProxy
   */
  protected $currentUser;
  protected $currentRouteMatch;
  protected $database;

  /**
   * Constructs a new AnnonceEventDispatcher object.
   */
  public function __construct(AccountProxyInterface $currentUser, RouteMatchInterface $currentRouteMatch, Connection $database) {
    $this->currentUser = $currentUser;
    $this->currentRouteMatch = $currentRouteMatch;
    $this->database = $database;
  }

  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = ['called'];
    return $events;
  }

  /**
   * This method is called whenever the kernel.request event is
   * dispatched.
   *
   * @param GetResponseEvent $event
   */


  public function called($event) {
    if ($this->currentRouteMatch->getParameter('annonce')){
      $this->database->insert('annonce_history')->fields(array(
        'aid' => $this->currentRouteMatch->getParameter('annonce')->id() ,
        'uid' => $this->currentUser->id(),
        'date' => REQUEST_TIME,
      ))->execute();
    }
  }


}
