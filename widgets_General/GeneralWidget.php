<?php

class GeneralWidget extends Widget {
    static $db = array(
        "Title" => "Varchar",
        "LinkLabel" => "Varchar",
        "CssClass" => "Varchar"
    );

    static $has_one = array(
        'SiteTree' => 'SiteTree'
    );

    static $cmsTitle = "General";
    
    public function getCustomTitle(){
    	return $this->Title;
    }

    public function getCustomLink(){
        return $this->SiteTree()->Link();
    }

    public function getCMSFields() {
//        $colorDropDown = new DropdownField('ColorID', 'Color', Color::get()->sort('Name')->map('ID', 'Name'));
//        $colorDropDown->setEmptyString('(Select Color)');
        $pageDropDown = new DropdownField('SiteTreeID', 'SiteTree', SiteTree::get()->sort('Title')->map('ID', 'Title'));
        $pageDropDown->setEmptyString('(Select Page)');
        //print_r($treedropdownfield);
        return new FieldList(
            new TextField("Title", "Title"),
            new TextField("LinkLabel", "LinkLabel"),
            new TextField("CssClass", "CssClass"),
            $pageDropDown
        );
    }
}

?>