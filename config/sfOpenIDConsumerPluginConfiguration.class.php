<?php

/*
 * This file is part of the sfOpenIDConsumerPlugin.
 * (c) 2010 Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfOpenIDConsumerPluginConfiguration does things.
 *
 * @package    sfOpenIDConsumerPlugin
 * @subpackage configurations
 * @author     Konstantin Kudryashov <ever.zet@gmail.com>
 * @version    1.0.0
 */
class sfOpenIDConsumerPluginConfiguration extends sfPluginConfiguration
{
  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    if (sfConfig::get('app_sf_openid_consumer_plugin_routes_register', true))
    {
      $this->dispatcher->connect('routing.load_configuration', array($this, 'addRoutes'));
    }
  }

  /**
   * Listens to the routing.load_configuration event & adds auth pages routes if needed
   *
   * @param sfEvent An sfEvent instance
   */
  static public function addRoutes(sfEvent $event)
  {
    $routes = $event->getSubject();

    $routes->prependRoute(
      'sf_openid_consumer_login', 
      new sfRoute(
        '/openid/login',
        array('module' => 'sfOpenIDConsumer', 'action' => 'login'),
        array('sf_method' => array('GET','POST'))
      )
    );

    $routes->prependRoute(
      'sf_openid_consumer_verify', 
      new sfRoute(
        '/openid/verify',
        array('module' => 'sfOpenIDConsumer', 'action' => 'verify')
      )
    );
  }
}