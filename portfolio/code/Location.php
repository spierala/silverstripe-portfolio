<?php
class Location extends DataObject {
    static $db = array (
        'Name' => 'Varchar(100)',
        'Subtitle' => 'Varchar(100)',
        'Slug' => 'Varchar(50)',
        'Latitude' => 'Decimal(20,16)',
        'Longitude' => 'Decimal(20,16)'
    );
}