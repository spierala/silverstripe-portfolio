<?php
class Location_Controller extends Page_Controller{
    public function index($arguments) {
        $slug = $arguments->param('Slug');
        $location = Location::get()->filter(array('Slug' => $slug))->First();
        if($location){
            $this->Lat = $location->Latitude;
            $this->Lng= $location->Longitude;
            $this->Location = $location->Title;
            $this->Subtitle= $location->Subtitle;
            $this->Key = $this->config()->key;
            return $this->renderWith(array('LocationPage', 'Page'));
        }
    }
}