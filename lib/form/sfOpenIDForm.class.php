<?php

/*
 * This file is part of the sfOpenIDConsumerPlugin.
 * (c) 2010 Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfOpenIDForm implements OpenID auth form.
 *
 * @package    sfOpenIDConsumerPlugin
 * @subpackage forms
 * @author     Konstantin Kudryashov <ever.zet@gmail.com>
 * @version    1.0.0
 */
class sfOpenIDForm extends BaseForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'identifier' => new sfWidgetFormInput
    ));

    $this->setValidators(array(
      'identifier' => new sfValidatorString(array(
        'required'    => true,
        'min_length'  => 2
      ))
    ));

    $this->getWidgetSchema()->setNameFormat('sf_openid[%s]');
  }
}