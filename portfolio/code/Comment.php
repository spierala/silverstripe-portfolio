<?php
class Comment extends DataObject {
    static $db = array(
    	'Name'			=> 'Varchar(200)',
		'Comment'		=> 'Text',
		'Email'			=> 'Varchar(200)',
		'URL'			=> 'Varchar(255)',
        'Approved'		=> 'Boolean'
    );
    
    static $has_one = array( 
		'BlogEntry' => 'BlogEntry'
	);
    
    public static $default_sort = 'Created DESC';
    
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main', new TextField('Created'));
        return $fields;
    }
    
    public function NiceComment() {
        return (nl2br  (Convert::raw2xml ($this->Comment), true));
    }
}
