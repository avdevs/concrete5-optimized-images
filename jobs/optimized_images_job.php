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

        $OptimizedImageSetting = new OptimizedImageSetting();
        $OptimizedImage =$OptimizedImageSetting->load();

        foreach($fileList as $file) {
            OptimizedImage::save($file['fID']);
            $fileObject = File::getByID($file['fID']);
            $source_img = DIR_APPLICATION.'/files/'. $fileObject->getFileResource()->getPath();
            $d = OptimizedImage::tinyPngCompress($source_img,  $OptimizedImage['tinyPngApiKey']);
        }

    }
}