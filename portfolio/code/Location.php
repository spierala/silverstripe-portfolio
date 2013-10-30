<?php
class Location extends DataObject {
    static $db = array (
        'Name' => 'Varchar(100)',
        'Subtitle' => 'Varchar(100)',
        'Slug' => 'Varchar(50)',
        'Latitude' => 'Varchar(10)',
        'Longitude' => 'Varchar(10)'
    );
}