<?php
/**
* @package   Plugin for detecting when site is visited by a robot.
* @version   0.0.1
* @author    http://www.brainforge.co.uk
* @copyright Copyright (C) 2013-2020 Jonathan Brain. All rights reserved.
* @license	 GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/
 
// no direct access
defined('_JEXEC') or die;

jimport( 'joomla.plugin.plugin');
jimport( 'joomla.environment.browser' );

class plgSystemBFisrobot extends JPlugin {
  /**
   *
   */
  function onAfterInitialise() {
    if (defined('IS_CRAWLER')) {
      return true;
    }
    if (!isset($_SERVER['HTTP_USER_AGENT'])) {
      return true;
    }

    // Catch robots defined in Joomla
 		$browser = JBrowser::getInstance();
    if ($browser->isrobot()) {
      define('IS_CRAWLER', $_SERVER['HTTP_USER_AGENT']);
      return true;
    }

    // Nothing personal, but catch any others we might have noticed
    // We can also detect by IP if really necessary
    $crawlers = array(
              '/robot/',
              '/bot.html',
              'a6-indexer',
              'abachobot',
              'accoona',
              'acoirobot',
              'admantx',
              'affectv',              
              'ahrefsbot',
              'altavista',
              'applebot',
              'aspseek',
              'baiduspider',
              'betabot',
              'bingbot',
              'blexbot',
              'ccbot',
              'cliqzbot',
              'crawler',
              'croccrawler',
              'curl',
              'dotbot',
              'duckduckbot',
              'duckduckgo',
              'dumbot',
              'estyle',
              'ezooms',
              'geonabot',
              'getintent',
              'googlebot',
              'googlebot-mobile',
              'grapeshotcrawler',
              'id-search bot',
              'idbot',
              'linkdexbot',
              'mediapartners-google',
              'megaindex',
              'msnbot',
              'msrbot',
              'mj12bot',
              'nutch',
              'pagebot',
              'petalbot',
              'proximic',
              'rambler',
              'rogerbot',
              'scrubby',
              'scoutjet',
              'semrushbot',
              'siteexplorer',
              'spbot',
              'uk_lddc_bot',
              'vagabondo',
              'wise guys',
              'xovi',
              'yandex',
              'yandexbot'
        );
  	$additional = $this->params->get('additional-crawlers');
 	  if (!empty($additional)) {
 	    $crawlers = array_merge($crawlers, explode(',', strtolower($additional)));
 	  }

    $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
    foreach($crawlers as $crawler) {
      $crawler = trim($crawler);
      if (strpos($useragent, $crawler) !== false) {
        if (empty($crawler)) {
          continue;
        }
        define('IS_CRAWLER', $_SERVER['HTTP_USER_AGENT']);
        return true;
      }
    }

    define('IS_CRAWLER', false);
    return true;
  }
}
?>
