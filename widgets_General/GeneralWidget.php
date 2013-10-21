<?php

class GeneralWidget extends Widget {
    static $db = array(
        'Title' => 'Varchar',
        'LinkLabel' => 'Varchar',
        'CssClass' => 'Varchar' 
    );

    static $has_one = array(
        'SiteTree' => 'SiteTree'
    );

    static $cmsTitle = 'General';
    static $description = 'General Widget to display a Title and an internal Link';
    
    public function getCustomTitle(){
    	return $this->Title;
    }

    public function getCustomLink(){
        return $this->SiteTree()->Link();
    }

    public function getCMSFields() {
        $pageDropDown = new DropdownField('SiteTreeID', 'LinkedPage', SiteTree::get()->sort('Title')->map('ID', 'Title'));
        $pageDropDown->setEmptyString('(Select Page)');
        return new FieldList(
            new TextField('Title'),
            new TextField('LinkLabel'),
            new TextField('CssClass', 'Icon Css Class'),
            $pageDropDown
        );
    }
}

?>