<?php
class ProjectAttribute extends DataObject {
    static $db = array(
        'Value' => 'Varchar',
        'Url' => 'Text'
    );
    
    static $has_one = array(
        'ProjectPage' => 'ProjectPage',
        'AttributeLabel' => 'AttributeLabel'
    ); 
    
    static $summary_fields = array(
        'AttributeLabel.Name' => 'Label',
        'Value' => 'Value'
    );
    
    static $defaults = array(
		'Type' => 'Normal'
	);
    
    public function scaffoldFormFields($_params = null) {
        $fields = parent::scaffoldFormFields($_params);
        $fields->changeFieldOrder(array('AttributeLabelID', 'Value', 'Url'));
        return $fields;
    }
}
