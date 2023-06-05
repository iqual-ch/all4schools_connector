<?php

namespace Drupal\all4schools_connector\Plugin;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Component\Plugin\PluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\all4schools_connector\Service\All4SchoolsClient;

/**
 * Provides a base implementation of an All4SchoolsConnector.
 *
 * @see \Drupal\all4schools_connector\Annotation\All4SchoolsConnector
 * @see \Drupal\all4schools_connector\All4SchoolsConnectorInterface
 */
abstract class All4SchoolsConnectorBase extends PluginBase implements ContainerFactoryPluginInterface, All4SchoolsConnectorInterface {

  /**
   * The All4School API Client.
   *
   * @var \Drupal\all4schools_connector\Service\All4SchoolsClient
   */
  protected $client;

  /**
   * Constructs a new All4SchoolsConnectorBase object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\all4schools_connector\Service\All4SchoolsClient $client
   *   The All4SchoolsClient service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, All4SchoolsClient $client) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->client = $client;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('all4schools_connector.client')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getCourses() {
    $courses = $this->client->request('GET', '/Api/Api/CourseWeb/GetAllCourses');
    return $courses;
  }

  /**
   * {@inheritdoc}
   */
  public function getSingleCourse($course_id) {
    $course = $this->client->request(
      'GET',
      '/Api/Api/CourseWeb/GetCourseData',
      [
        'courseId' => $course_id,
      ]
    );
    return $course;
  }

  /**
   * {@inheritdoc}
   */
  public function postRegistration($data) {
    $response = $this->client->request('POST', '/Api/Api/CourseWeb/AddCourseParticipantWithoutFiles');
    return $response;
  }

}
