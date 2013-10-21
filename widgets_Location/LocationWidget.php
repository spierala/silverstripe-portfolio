<?php

class LocationWidget extends WidgetBase {
    static $cmsTitle = 'Location';
    static $description = 'Display Location (set in Settings)';

    static $has_one = array(
        'Location' => 'Location'
    );

    public function getCMSFields() {
        $locationDropDown = new DropdownField('LocationID', 'Choose Location', $this->getLocationOptions());
        $locationDropDown->setEmptyString('(Select Location)');
        $locationDropDown->setDescription('Create new Locations in Model Admin');

        $fields = parent::getCMSFields();
        $fields->push($locationDropDown);
        return $fields;
    }

    private function getLocationOptions() {
        if($Pages = DataObject::get('Location')) {
            return $Pages->map('ID', 'Title', 'Please Select');
        } else {
            return array('No Objects found');
        }
    }
}

class LocationWidgetController extends Widget_Controller {
    //use custom template
    public function Content() {
        return $this->renderWith('LocationWidget');
    }
}

?>