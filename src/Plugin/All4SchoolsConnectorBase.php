<?php

namespace Drupal\all4schools_connector\Plugin;

use Drupal\Component\Plugin\PluginBase;

/**
 * Provides \Drupal\all4schools_connector\All4SchoolsConnectorBase.
 *
 * @see \Drupal\all4schools_connector\Annotation\All4SchoolsConnector
 * @see \Drupal\all4schools_connector\All4SchoolsConnectorInterface
 */
abstract class All4SchoolsConnectorBase extends PluginBase implements All4SchoolsConnectorInterface {

  /**
   * {@inheritdoc}
   */
  public function getCourses() {
    $client = \Drupal::container('all4school_connector.client');
    $courses = $client->request('/Api/Api/CourseWeb/GetAllCourses');
    return $courses;
  }

}
