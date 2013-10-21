<?php

class LocationWidget extends GeneralWidget {
    static $cmsTitle = 'Location';
    static $description = 'Display Location (set in Settings)';

    public function getCMSFields() {
        return new FieldList(
            new TextField('Title'),
            new TextField('CssClass')
        );
    }

    public function getLocation(){
        return SiteConfig::current_site_config()->Location;
    }

    public function getLocationLabel(){
        return SiteConfig::current_site_config()->LocationLabel;
    }
}

class LocationWidgetController extends Widget_Controller {
    //use custom template
    public function Content() {
        return $this->renderWith('LocationWidget');
    }
}

?>