<?php

/**
 * @file
 * Contains \Drupal\all4schools_connector\Annotation\All4SchoolsConnector.
 *
 */

namespace Drupal\all4schools_connector\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines an All4SchoolsConnector annotation object.
 *
 * @see \Drupal\all4schools_connector\Plugin\All4SchoolsConnectorPluginManager
 * @see plugin_api
 *
 *
 * @Annotation
 */
class All4SchoolsConnector extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

}