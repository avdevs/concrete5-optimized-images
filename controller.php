<?php
namespace Concrete\Package\OptimizedImages;
use Package;
use Concrete\Core\Backup\ContentImporter;
use Events;
use Concrete\Package\OptimizedImages\Src\OptimizedImage ;
class Controller extends Package {

    protected $pkgHandle = 'optimized_images';
    protected $appVersionRequired = '5.7.1';
    protected $pkgVersion = '0.10.3';
    protected $map = [
        'optimizedImageSetting.tinyPngApiKey' => 'tinyPngApiKey',
        'optimizedImageSetting.allowCustomThumbOptimize' => 'allowCustomThumbOptimize',
    ];
    public function getPackageDescription() {
        return t("Package for optimize your image size");
    }

    public function getPackageName() {
        return t("Optimize Image Size");
    }

    protected function installXmlContent()
    {
        $pkg = Package::getByHandle($this->pkgHandle);

        $ci = new ContentImporter();
        $ci->importContentFile($pkg->getPackagePath() . '/install.xml');
    }

    public function install() {
        $pkg = parent::install();
        $this->installXmlContent();
        $this->processInstallOptions();
    }

    public function upgrade() {
        $pkg = parent::upgrade();
        $this->installXmlContent();
    }

    public function getConfigMap()
    {
        return $this->map;
    }

    private function processInstallOptions()
    {
        $pkg = Package::getByHandle($this->pkgHandle);
        $map = $this->getConfigMap();

        foreach ($map as $configKey => $formElement) {
            $data = $_REQUEST[$formElement];
            $pkg->getConfig()->save($configKey, $data);
        }
    }

    public function on_start() {
        $pkg = Package::getByHandle($this->pkgHandle);
        $config = $pkg->getConfig();
        $allowCustomThumbOptimize = $config->get('optimizedImageSetting.allowCustomThumbOptimize');
        if($allowCustomThumbOptimize != 1){
            Events::addListener('on_file_add', function(){
                $fileList = OptimizedImage::getLastRecord();
                $pkg = Package::getByHandle('optimized_images');
                $config = $pkg->getConfig();
                $tinyPngApiKey = $config->get('optimizedImageSetting.tinyPngApiKey');
                $fileObject = \File::getByID($fileList);
                $ext = pathinfo($fileObject->getFileName(), PATHINFO_EXTENSION);
                $imageExtesions = array('jpg', 'jpeg', 'png', 'JPEG', 'PNG', 'JPG');
                if (in_array($ext, $imageExtesions)) {
                    $source_img = DIR_FILES_UPLOADED_STANDARD . '/' . $fileObject->getFileResource()->getPath();
                    if (file_exists($source_img)) {
                        $d = OptimizedImage::tinyPngCompress($source_img, $tinyPngApiKey);
                        if(!$d){
                            OptimizedImage::save($fileList);
                        }
                    }
                }
            });
        }
    }
}