<?php
namespace Concrete\Core\File\Search\Field;

use Concrete\Core\File\Search\Field\Field\AddedToPageField;
use Concrete\Core\File\Search\Field\Field\DateAddedField;
use Concrete\Core\File\Search\Field\Field\ExtensionField;
use Concrete\Core\File\Search\Field\Field\SizeField;
use Concrete\Core\File\Search\Field\Field\TypeField;
use Concrete\Core\Foundation\Service\Provider as ServiceProvider;
use Concrete\Core\File\Search\Field\Manager;

class ManagerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app['manager/search_field/file'] = $this->app->share(function ($app) {
            $manager = $this->app->make('Concrete\Core\File\Search\Field\Manager');
            return $manager;
        });
    }
}
