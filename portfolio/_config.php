<?php

global $project;
$project = 'portfolio';

// Use _ss_environment.php file for configuration
require_once("conf/ConfigureFromEnv.php");

Object::add_extension('SiteConfig', 'CustomSiteConfig');
Object::add_extension("SiteTree", "FilesystemPublisher('cache/', 'html')");