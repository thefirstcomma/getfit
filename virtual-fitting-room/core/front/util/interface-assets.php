<?php
namespace Virtual_Fitting_Room\Core\Front\Util;

/**
 * Defines a common set of functions that any class responsible for loading
 * stylesheets, JavaScript, or other assets should implement.
 */
interface Assets_Interface {
 
    // public function init();
    public function enqueue();
 
}