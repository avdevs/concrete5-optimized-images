<?php
namespace Concrete\Package\OptimizedImages;
use Package;
use Concrete\Core\Backup\ContentImporter;

class Controller extends Package {

    protected $pkgHandle = 'optimized_images';
    protected $appVersionRequired = '5.7.1';
    protected $pkgVersion = '0.9.7';

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

        \Concrete\Core\Job\Job::installByPackage('optimized_images_job', $pkg);
        $this->installXmlContent();
    }

    public function upgrade() {
        $pkg = parent::upgrade();

        $this->installXmlContent();
    }

}