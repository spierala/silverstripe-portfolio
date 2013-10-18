<?php

class LocationWidget extends Widget {
    static $cmsTitle = "Location";
    static $description = "Display Location (set in Settings)";

    public function getLocation(){
        return SiteConfig::current_site_config()->Location;
    }

    public function getLocationLabel(){
        return SiteConfig::current_site_config()->LocationLabel;
    }
}

?>