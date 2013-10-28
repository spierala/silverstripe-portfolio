<?php
class CustomMemberExtension extends DataExtension {
    private static $db = array(
        'GooglePlusAuthorLink' => 'Varchar(255)'
    );

    function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab("Root.Main", new TextField('GooglePlusAuthorLink'));
        return $fields;
    }
}