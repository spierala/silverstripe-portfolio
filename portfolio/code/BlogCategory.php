<?php
class BlogCategory extends DataObject {
    static $db = array(
        'Name' => 'Varchar',
        'Slug' => 'Varchar'
    );
    static $belongs_many_many = array(
        'BlogEntries' => 'BlogEntry'
    ); 
    
    public function getNumOfEntries() {
        return count($this->BlogEntries());
    }

    public function LinkingMode() {
        $categoryID = Controller::curr()->BlogCategoryID;
		return ($categoryID == $this->ID) ? 'current' : 'link';
	}
}
