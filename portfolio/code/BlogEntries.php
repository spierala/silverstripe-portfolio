<?php
class BlogEntries extends Page {
    private static $allowed_children = array("BlogEntry");
    private static $description = 'Holder for BlogEntry - Pages';

    public function LinkingMode(){
        return (Controller::curr()->ClassName == 'BlogEntries' || Controller::curr()->ClassName == 'BlogEntry') ? 'current' : 'link';
    }

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeFieldFromTab('Root.Main', 'ShowSocial');
        return $fields;
    }
}

class BlogEntries_Controller extends Page_Controller {
    public function getEntries() {
        return BlogEntry::get()->sort('Date DESC');
    }
}