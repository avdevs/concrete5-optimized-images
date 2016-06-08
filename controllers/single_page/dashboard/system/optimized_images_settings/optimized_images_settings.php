<?php
namespace Concrete\Package\OptimizedImages\Controller\SinglePage\Dashboard\System\OptimizedImagesSettings;

defined('C5_EXECUTE') or die('Access Denied.');

use \Concrete\Core\Page\Controller\DashboardPageController,
    Package,
    View,
    PageController;
use Database,
    Loader,
    Core;
class OptimizedImagesSettings extends DashboardPageController
{
    protected $helpers = array('form');

    public function view()
    {
        $pkg = Package::getByHandle('optimized_images');
        $config = $pkg->getConfig();

        $map = $pkg->getConfigMap();

        foreach ($map as $configKey => $formField) {
            $data = $config->get($configKey);

            // try to convert to an array
            if (!is_array($data)) {
                $convertedValue = unserialize($data);
                if (is_array($convertedValue)) {
                    $data = $convertedValue;
                }
            }

            $this->set($formField, $data);
        }
    }

    public function save()
    {
        $pkg = Package::getByHandle('optimized_images');
        $config = $pkg->getConfig();

        $map = $pkg->getConfigMap();
        foreach ($map as $configKey => $formField) {
            $data = $this->post($formField);
            $config->save($configKey, $data);
        }
        $this->flash("message", t('Setting Updated.'));
        $this->redirect('/dashboard/system/optimized_images_settings/optimized_images_settings');
    }

}
