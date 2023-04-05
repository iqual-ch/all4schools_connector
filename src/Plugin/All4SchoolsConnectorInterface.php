<?php

namespace Drupal\all4schools_connector;

/**
 * An interface for all All4SchoolsConnector type plugins.
 */
interface All4SchoolsConnectorInterface {

  /**
   * Get all courses from All4Schools.
   *
   * @return mixed
   */
  public function getCourses();

}
