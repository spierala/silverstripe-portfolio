<?php
class CustomMember extends Member {
    private static $db = array(
        'GooglePlusAuthorLink' => 'Varchar(255)'
    );

    public function getCMSFields(){
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main', new TextField('GooglePlusAuthorLink', 'GooglePlusAuthorLink'));
        return $fields;
    }
}