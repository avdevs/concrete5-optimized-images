<?php
namespace Concrete\Package\OptimizedImages\Controller\SinglePage\Dashboard\System\OptimizedImagesSettings;

defined('C5_EXECUTE') or die('Access Denied.');

use \Concrete\Core\Page\Controller\DashboardPageController,
    Package,
    View,
    Concrete\Package\OptimizedImages\Src\OptimizedImageSetting;
use Database,
    Core;
class OptimizedImagesSettings extends DashboardPageController
{
    protected $helpers = array('form');

    public function view()
    {
        $optimizedImageSetting = OptimizedImageSetting::load();
        $this->set('optimizedImageSetting', $optimizedImageSetting);
    }

    public function save()
    {
        $OptimizedImagesSettings = new OptimizedImageSetting();
        $OptimizedImagesSettings->setTinyPngApiKey($this->post('tinyPngApiKey'));
        if($this->post('ID')){
            $OptimizedImagesSettings->setID($this->post('ID'));
            $OptimizedImagesSettings->update();
        }else{
            $OptimizedImagesSettings->save();
        }
        $this->flash("message", t('Setting Updated.'));
        $this->redirect('/dashboard/system/optimized_images_settings/optimized_images_settings');
    }

}
