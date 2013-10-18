<?php
class Category extends DataObject {
    static $db = array(
        'Name' => 'Varchar',
        'Slug' => 'Varchar'
    );
    static $belongs_many_many = array(
        'ProjectPages' => 'ProjectPage'
    ); 
    
    public function getNumOfProjects() {
        return count($this->ProjectPages());
    }
    
    public function LinkingMode() {
        $categoryID = Controller::curr()->CategoryID;
		return ($categoryID == $this->ID) ? 'current' : 'link';
	}
}
