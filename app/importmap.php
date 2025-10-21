<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
  'app' => [
    'path' => './assets/app.js',
    'entrypoint' => true,
  ],
  'modal' => [
    'path' => './assets/js/modal.js',
    'entrypoint' => true,
  ],
  'collection' => [
    'path' => './assets/js/collection_managment.js',
    'entrypoint' => true,
  ],
  'activity' => [
    'path' => './assets/js/activity.js',
    'entrypoint' => true,
  ],
  'flatpickr' => [
    'path' => './assets/js/flatpickr-config.js',
    'entrypoint' => true,
  ],
  'datetimepicker' => [
    'path' => './assets/js/dtpkr_init.js',
    'entrypoint' => true,
  ],
  'auto-resize-textarea' => [
    'path' => './assets/js/auto-resize-textarea.js',
    'entrypoint' => true,
  ],
  'homepage-modals' => [
    'path' => './assets/js/homepage-modals.js',
    'entrypoint' => true,
  ],
  'pid-help-modal' => [
    'path' => './assets/js/pid_help_modal.js',
    'entrypoint' => true,
  ],
];
