<?php
class ProjectImage extends DataObject {
	static $db = array (
        'isPreview' => 'Boolean'
	);
    
	static $has_one = array ( 
		'ProjectPage' => 'ProjectPage', 
	 	'Image' => 'Image' 
	);
    
    static $summary_fields = array(
        'Image.Title' => 'Label'
    );
}