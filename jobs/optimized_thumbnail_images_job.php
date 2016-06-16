<?php
namespace Concrete\Package\OptimizedImages\Job;
use \Concrete\Core\Job\Job as AbstractJob;
use Core;
use Database;
use Concrete\Package\OptimizedImages\Src\OptimizedThumbImageJob ;
use File;
use Package;
use Config;
use Job;
use Concrete\Core\File\Image\Thumbnail\Type\Type;
class OptimizedThumbnailImagesJob extends AbstractJob
{

    public function getJobName()
    {
        return t("Optimized Custom Thumbnail Images Job.");
    }

    public function getJobDescription()
    {
        return t("Takes all custom thumbnail image files and optimize size of it.");
    }

    public function run()
    {
        $pkg = Package::getByHandle('optimized_images');
        $config = $pkg->getConfig();
        $tinyPngApiKey = $config->get('optimizedImageSetting.tinyPngApiKey');
        $allowCustomThumbOptimize = $config->get('optimizedImageSetting.allowCustomThumbOptimize');
        if($allowCustomThumbOptimize == 1) {
            $fileList = scandir(Config::get('concrete.cache.directory'));
            $jobLastRunDate = OptimizedThumbImageJob::load();
            foreach ($fileList as $file) {
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                $imageExtesions = array('jpg', 'jpeg', 'png', 'JPEG', 'PNG', 'JPG');
                if (in_array($ext, $imageExtesions)) {
                    $source_img = Config::get('concrete.cache.directory') . '/' . $file;
                    $fileModifiedDate = date("F d Y H:i:s", filemtime($source_img));
                    if (file_exists($source_img)) {
                        if ($fileModifiedDate > $jobLastRunDate) {
                            //Optimize image using tinyPngCompress
                            $d = OptimizedThumbImageJob::tinyPngCompress($source_img, $tinyPngApiKey);
                        }
                    }
                }
            }
            if (!$jobLastRunDate) {
                OptimizedThumbImageJob::save(date("F d Y H:i:s"));
            } else {
                OptimizedThumbImageJob::update(date("F d Y H:i:s"));
            }
        }
    }
}