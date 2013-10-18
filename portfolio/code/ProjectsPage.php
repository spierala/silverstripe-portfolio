<?php

class ProjectsPage extends Page {
    private static $allowed_children = array("ProjectPage");
    private static $description = 'Displays the Portfolio - Holder for ProjectPages';

    public function LinkingMode() {
        return (Controller::curr()->ClassName == 'ProjectPage' || Controller::curr()->ClassName == 'ProjectsPage') ? 'current' : 'link';
    }

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeFieldFromTab('Root.Main', 'ShowSocial');
        return $fields;
    }

    public function getProjects() {
        return ProjectPage::get()->sort('Sort', 'ASC');
    }
}

class ProjectsPage_Controller extends Page_Controller {

}