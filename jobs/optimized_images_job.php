<?php
namespace Concrete\Package\OptimizedImages\Job;
use \Concrete\Core\Job\Job as AbstractJob;
use Core;
use Database;
use Concrete\Package\OptimizedImages\Src\OptimizedImage ;
use Concrete\Package\OptimizedImages\Src\OptimizedImageSetting;
use File;
class OptimizedImagesJob extends AbstractJob
{

    public function getJobName()
    {
        return t("Optimized Images Job.");
    }

    public function getJobDescription()
    {
        return t("Takes all image files and optimize size of it.");
    }

    public function run()
    {
        $fileList = OptimizedImage::load();


        foreach($fileList as $file) {
            OptimizedImage::save($file['fID']);
            $fileObject = File::getByID($file['fID']);
            $OptimizedImageSetting = new OptimizedImageSetting();
            $OptimizedImage =$OptimizedImageSetting->load();
            $imageHelper = Core::make('helper/image');

            $source_img = DIR_APPLICATION.'/files/'. $fileObject->getFileResource()->getPath();
            $destination_img = DIR_APPLICATION.'/files/'. $fileObject->getFileResource()->getPath();

            $d = OptimizedImage::compress($source_img, $destination_img, $OptimizedImage['optimizedImagesQuality']);

            //var_dump($d);
        }


die;

    }
}