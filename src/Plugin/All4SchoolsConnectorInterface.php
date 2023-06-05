<?php

namespace Drupal\all4schools_connector\Plugin;

/**
 * An interface for all All4SchoolsConnector type plugins.
 */
interface All4SchoolsConnectorInterface {

  /**
   * Get all courses from All4Schools.
   *
   * @return array
   *   All courses data in an array.
   */
  public function getCourses();

  /**
   * Get a single course from All4Schools.
   *
   * @param int $course_id
   *   The course identifier in All4Schools.
   *
   * @return array
   *   An array of data for a single course matching the given course id.
   */
  public function getSingleCourse(int $course_id);

}
