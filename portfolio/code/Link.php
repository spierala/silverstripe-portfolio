<?php
class Link extends DataObject {
    static $db = array(
        'Name' => 'Varchar',
        'URL' => 'Varchar(255)'
    );

    static $has_one = array (
        'Tag' => 'Tag'
    );
}
