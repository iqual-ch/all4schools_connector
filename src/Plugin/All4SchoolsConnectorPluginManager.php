<?php

namespace Drupal\all4schools_connector\Plugin;

use Drupal\all4schools_connector\Annotation\All4SchoolsConnector;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * A plugin manager for All4Schools connector plugins.
 */
class All4SchoolsConnectorPluginManager extends DefaultPluginManager {

  /**
   * Creates the discovery object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    $subdir = 'Plugin/All4Schools';

    // The name of the interface that plugins should adhere to. Drupal will
    // enforce this as a requirement. If a plugin does not implement this
    // interface, than Drupal will throw an error.
    $plugin_interface = 'Drupal\all4schools_connector\Plugin\All4SchoolsConnectorInterface';

    // The name of the annotation class that contains the plugin definition.
    $plugin_definition_annotation_name = All4SchoolsConnector::class;

    parent::__construct($subdir, $namespaces, $module_handler, $plugin_interface, $plugin_definition_annotation_name);

    // This allows the plugin definitions to be altered by an alter hook.
    $this->alterInfo('all4schools_connector_info');

    $this->setCacheBackend($cache_backend, 'all4schools_connector_info');
  }

}
