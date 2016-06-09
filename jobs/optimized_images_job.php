<?php
namespace Concrete\Package\OptimizedImages\Job;
use \Concrete\Core\Job\Job as AbstractJob;
use Core;
use Database;
use Concrete\Package\OptimizedImages\Src\OptimizedImage ;
use File;
use Package;
use Concrete\Core\File\Image\Thumbnail\Type\Type;
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
        $pkg = Package::getByHandle('optimized_images');
        $config = $pkg->getConfig();
        $tinyPngApiKey = $config->get('optimizedImageSetting.tinyPngApiKey');

        foreach($fileList as $file) {
            OptimizedImage::save($file['fID']);
            $fileObject = File::getByID($file['fID']);
            $ext = pathinfo($fileObject->getFileName(), PATHINFO_EXTENSION);
            $imageExtesions = array('jpg', 'jpeg', 'png', 'JPEG', 'PNG', 'JPG');
            if (in_array($ext, $imageExtesions)) {
                $source_img = DIR_FILES_UPLOADED_STANDARD . '/' . $fileObject->getFileResource()->getPath();
                if (file_exists($source_img)) {
                    $d = OptimizedImage::tinyPngCompress($source_img, $tinyPngApiKey);
                }
            }
        }

    }
}