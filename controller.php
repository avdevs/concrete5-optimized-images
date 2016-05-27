<?php
namespace Concrete\Package\OptimizedImages;
use Package;
use Concrete\Core\Backup\ContentImporter;
use Events;
use Concrete\Package\OptimizedImages\Job\OptimizedImagesJob;
class Controller extends Package {

    protected $pkgHandle = 'optimized_images';
    protected $appVersionRequired = '5.7.1';
    protected $pkgVersion = '0.9.9';

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
    }

    public function upgrade() {
        $pkg = parent::upgrade();

        $this->installXmlContent();
    }

    public function on_start() {
        Events::addListener('on_file_add', function(){ OptimizedImagesJob::run(); } );
    }
}