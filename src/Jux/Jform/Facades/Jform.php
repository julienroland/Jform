<?php
namespace Jux\Jform\Facades;

use \Illuminate\Support\Facades\Facade;

class Jform extends Facade {

    protected static function getFacadeAccessor() {

        return 'jform';

    }

}