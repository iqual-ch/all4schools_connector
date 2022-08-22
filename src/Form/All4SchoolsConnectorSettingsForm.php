<?php

namespace Drupal\all4schools_connector\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provide the settings form for the All4Schools Connector.
 */
class All4SchoolsConnectorSettingsForm extends ConfigFormBase implements ContainerInjectionInterface {

  /**
   * {@inheritdoc}
   */
  public function getEditableConfigNames() {
    return ['all4schools_connector.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'all4schools_connector_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('all4schools_connector.settings');

    $form['base_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Base url'),
      '#default_value' => $config->get('base_url'),
      '#description' => $this->t('The URL of the All4Schools instance with protocol (https).'),
      '#required' => TRUE,
    ];
    $form['request_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Request Id'),
      '#default_value' => $config->get('request_id'),
      '#description' => $this->t('The client request id for this All4Schools instance'),
      '#required' => TRUE,
    ];
    $form['app_user_id'] = [
        '#type' => 'textfield',
        '#title' => $this->t('App User Id'),
        '#default_value' => $config->get('app_user_id'),
        '#description' => $this->t('The client app user id for this All4Schools instance'),
        '#required' => TRUE,
      ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('all4schools_connector.settings');
    $form_state->cleanValues();

    $config->set('base_url', $form_state->getValue('base_url'));
    $config->set('request_id', $form_state->getValue('request_id'));
    $config->set('app_user_id', $form_state->getValue('app_user_id'));

    $config->save();

    parent::submitForm($form, $form_state);
  }

}
