<?php
namespace Concrete\Package\OptimizedImages\Controller\SinglePage\Dashboard;

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
        $optimizedImagesQuality = OptimizedImageSetting::load();
        $this->set('optimizedImagesQuality', $optimizedImagesQuality);
    }

    public function save()
    {
        $OptimizedImagesSettings = new OptimizedImageSetting();
        $OptimizedImagesSettings->setOptimizedImagesQuality($this->post('optimizedImagesQuality'));
        if($this->post('ID')){
            $OptimizedImagesSettings->setID($this->post('ID'));
            $OptimizedImagesSettings->update();
        }else{
            $OptimizedImagesSettings->save();
        }
        $this->flash("message", t('Setting Updated.'));
        $this->redirect('/dashboard/optimized_images_settings/');
    }

}
