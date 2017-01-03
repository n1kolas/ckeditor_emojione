<?php

/**
 * @file
 * Contains \Drupal\ckeditor_emojione\Plugin\CKEditorPlugin\EmojioneButton.
 */

namespace Drupal\ckeditor_emojione\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Asset\LibraryDiscoveryInterface;
use Drupal\editor\Entity\Editor;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines the "emojione" plugin.
 *
 * @CKEditorPlugin(
 *   id = "emojione",
 *   label = @Translation("Emojione")
 * )
 */

class EmojioneButton extends CKEditorPluginBase implements ContainerFactoryPluginInterface {

  /**
   * The Library Discovery service.
   *
   * @var \Drupal\Core\Asset\LibraryDiscoveryInterface
   */
  protected $libraryDiscovery;

  /**
   * Constructs a PluginBase object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Asset\LibraryDiscoveryInterface $library_discovery
   *   The library discovery service.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    LibraryDiscoveryInterface $library_discovery
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->libraryDiscovery = $library_discovery;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(
    ContainerInterface $container,
    array $configuration,
    $plugin_id,
    $plugin_definition
  ) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('library.discovery')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function isInternal() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function getFile() {
    $library = $this->libraryDiscovery->getLibraryByName('ckeditor_emojione', 'ckeditor_emojione');

    return $library['js'][0]['data'];
  }

  /**
   * {@inheritdoc}
   */
  public function getConfig(Editor $editor) {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  function getDependencies(Editor $editor) {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  function getLibraries(Editor $editor) {
    $libraries = parent::getLibraries($editor);
    $libraries[] = 'ckeditor_emojione/emojione';
    return $libraries;
  }

  /**
   * {@inheritdoc}
   */
  public function getButtons() {
    $library = $this->libraryDiscovery->getLibraryByName('ckeditor_emojione', 'ckeditor_emojione');

    return [
      'Emojione' => [
        'label' => t('Emojione button'),
        'image' => $library['icon'],
      ],
    ];
  }
}
