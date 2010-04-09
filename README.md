sfOpenIDConsumerPlugin
====

*OpenID consumer plugin for symfony*

sfOpenIDConsumerPlugin is a plugin for symfony applications. It implements basic OpenID authorization process, that you can hook in.

Installation
============

Prerequisites: Zend Framework
-----------------------------------

There's need to install zend framework for your application. To do this:

1. Download zend framework & unzip it;
2. Put library/Zend folder under your project's lib/vendor/zend
3. Add this to your `ProjectConfiguration::setup()` method:

	// Integrate Zend Framework
	if ($sf_zend_lib_dir = sfConfig::get('sf_lib_dir') . '/vendor')
	{
	  set_include_path($sf_zend_lib_dir.PATH_SEPARATOR.get_include_path());
	  require_once($sf_zend_lib_dir.'/zend/Loader/Autoloader.php');
	  spl_autoload_register(array('Zend_Loader_Autoloader', 'autoload'));
	}

Using git clone
-----------------------------------

Use this to install as a plugin in a symfony app:

	$ cd plugins && git clone git://github.com/everzet/sfOpenIDConsumerPlugin.git

Using git submodules
-----------------------------------

Use this if you prefer to use git submodules for plugins:

	$ git submodule add git://github.com/everzet/sfOpenIDConsumerPlugin.git plugins/sfOpenIDConsumerPlugin

Configuring your applications
-----------------------------------

Add this line to `ProjectConfiguration::setup()` method:

	$this->enablePlugins('sfOpenIDConsumerPlugin');


Usage
=====

After installation, you need to write your own actions, that will extends `sfOpenIDConsumerBaseActions`. Look at `sfOpenIDConsumerBaseActions::executeLogin()` & `sfOpenIDConsumerBaseActions::executeVerify()` actions to understand how controller works. You can hook in 


Contributors
============

* everzet (lead): [http://github.com/everzet](http://github.com/everzet)

Based on [zend framework's](http://framework.zend.com/) OpenID consumer plugin
