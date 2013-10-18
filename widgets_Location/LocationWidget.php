<?php

class LocationWidget extends Widget {
    static $cmsTitle = "Location";

    static $db = array(
        "CssClass" => "Varchar"
    );

    public function getLocation(){
        return SiteConfig::current_site_config()->Location;
    }

    public function getLocationLabel(){
        return SiteConfig::current_site_config()->LocationLabel;
    }

    public function getCMSFields() {
        return new FieldList(
            new TextField("CssClass", "CssClass")
        );
    }
}

?>