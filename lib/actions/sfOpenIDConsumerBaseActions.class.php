<?php

/*
 * This file is part of the sfOpenIDConsumerPlugin.
 * (c) 2010 Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfOpenIDConsumerBaseActions implements OpenID registration/authentication.
 *
 * @package    sfOpenIDConsumerPlugin
 * @subpackage actions
 * @author     Konstantin Kudryashov <ever.zet@gmail.com>
 * @version    1.0.0
 */
class sfOpenIDConsumerBaseActions extends sfActions
{
  /**
   * Executes login action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeLogin(sfWebRequest $request)
  {
    $this->form = new sfOpenIDForm;

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid())
      {
        $values   = $this->form->getValues();
        $back_url = $this->generateUrl('sf_openid_consumer_verify', array(), true);

        if(!$this->login($values['identifier'], $back_url))
        {
          $this->getUser()->setFlash('sf_openid.error', 'You\'ve entered wrong OpenID');
        }
      }
    }
  }

  /**
   * Executes verify action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeVerify(sfWebRequest $request)
  {
    if(false === ($properties = $this->verify($request->getGetParameters())))
    {
      $this->getUser()->setFlash('sf_openid.error', 'Can\'t verify your OpenID');
    }
    else
    {
      $this->getUser()->setFlash('sf_openid.success', 'You\'ve successfully logged in');
      $this->processSregProperties($properties);
    }

    $this->redirect($this->generateUrl('sf_openid_consumer_login'));
  }

  /**
   * Process SREG properties, returned by provider. Override this method to do something
   *
   * @param array $properties array of properties
   */
  protected function processSregProperties(array $properties) {}

  /**
   * Executed OpenID login redirect
   *
   * @param   string $identifier  OpenID identifier
   * @param   string $back_url    url to go after OpenID login
   * 
   * @return  boolean             true if login succes & false otherways
   */
  protected function login($identifier, $back_url)
  {
    $consumer = $this->getConsumer();

    return $consumer->login($identifier, $back_url, null, $this->getSreg());
  }

  /**
   * Executes OpenID verify of OpenID login response
   *
   * @param   array $parameters array of GET parameters
   * @return  boolean|array     array of required/optional fields on success & false in otherways
   */
  protected function verify(array $parameters)
  {
    $consumer = $this->getConsumer();
    $sreg     = $this->getSreg();
    $id       = null;

    if ($consumer->verify($parameters, $identifier, $sreg))
    {
      return array_merge(array('identifier' => $identifier), $sreg->getProperties());
    }
    else
    {
      return false;
    }
  }

  /**
   * Returns preconfigured OpenID consumer object
   *
   * @return Zend_OpenId_Consumer
   */
  protected function getConsumer()
  {
    return new Zend_OpenId_Consumer;
  }

  /**
   * Returns preconfigured OpenID sreg object
   *
   * @return Zend_OpenId_Extension_Sreg
   */
  protected function getSreg()
  {
    $fields = array();

    foreach (sfConfig::get('app_sf_openid_consumer_plugin_fields', array()) as $field => $req)
    {
      $fields[$field] = (bool) $req;
    }

    return new Zend_OpenId_Extension_Sreg(
      $fields, null, sfConfig::get('app_sf_openid_consumer_plugin_ver', 1.1)
    );
  }
}