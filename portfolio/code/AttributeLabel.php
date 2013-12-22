<?php
class AttributeLabel extends DataObject {
    static $db = array(
        'Name' => 'Varchar'
    );
    
    static $has_many = array(
        'ProjectAttributes' => 'ProjectAttribute'
    );

    public function getCMSFields() {

        // Adding the Description field early will allow FluentField to decorate this with the appropriate
        // CSS classes.
        $this->beforeUpdateCMSFields(function($fields) {
            $fields->addFieldToTab('Root.Main', new TextField('Name'));
        });

        // The result of this call will have had beforeUpdateCMSFields then updateCMSFields called on it
        $fields = parent::getCMSFields();
        $fields->removeByName('Content', true);
        return $fields;
    }
}
