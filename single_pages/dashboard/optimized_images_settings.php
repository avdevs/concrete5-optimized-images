<?php
defined('C5_EXECUTE') or die('Access Denied.');

$taskElements = array(

    'view' => 'optimized_images_settings',
    'save' => 'optimized_images_settings',
);


$element = $taskElements[$this->controller->getTask()];

View::element($element, get_defined_vars() + ['view' => $this], 'optimized_images');
?>
