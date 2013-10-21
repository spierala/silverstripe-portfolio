<?php

class GeneralWidget extends WidgetBase {
    static $db = array(
        'LinkLabel' => 'Varchar'
    );

    static $has_one = array(
        'SiteTree' => 'SiteTree'
    );

    static $cmsTitle = 'General';
    static $description = 'General Widget to display a Title and an internal Link';

    public function getCustomLink(){
        return $this->SiteTree()->Link();
    }

    public function getCMSFields() {
        $pageDropDown = new DropdownField('SiteTreeID', 'LinkedPage', SiteTree::get()->sort('Title')->map('ID', 'Title'));
        $pageDropDown->setEmptyString('(Select Page)');

        $fields = parent::getCMSFields();
        $fields->push($pageDropDown);
        $fields->push(new TextField('LinkLabel'));
        return $fields;
    }
}

?>