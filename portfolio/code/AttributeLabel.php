<?php
class AttributeLabel extends DataObject {
    static $db = array(
        'Name' => 'Varchar'
    );
    
    static $has_many = array(
        'ProjectAttributes' => 'ProjectAttribute'
    ); 
}
