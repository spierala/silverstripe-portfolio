<?php
class MapPage extends Page {
    private static $description = 'Displays your location on GoogleMaps';

    public function getLocation() {
        return SiteConfig::current_site_config()->Location;
    }

    public function getLocationLabel() {
        return SiteConfig::current_site_config()->LocationLabel;
    }

    public function getKey() {
        return $this->config()->key;
    }
}

class MapPage_Controller extends Page_Controller {

}