# silverstripe-portfolio

## Overview
**silverstripe-portfolio** is a real world example of a portfolio website based on silverstripe. It demonstrates many silverstripe functionalities and includes some of the most common silverstripe-modules:
 
* googlesitemaps
* staticpublisher
* widgets

here you can see silverstripe-portfolio in action:
[Portfolio Florian Spier](http://www.florian-spier.de)


## Installation
I recommend to use git clone in your console:

`git clone git@github.com:spierala/silverstripe-portfolio.git`

To update the related silverstripe-modules (googlesitemaps etc.) you have to execute these commands:

`git submodule init`

`git submodule update`

Of course you can download everything manually as well. Keep in mind submodules are not included if you choose 'Download ZIP'.

## Configuration
Edit this files to configure the website and the database connection:

* **_ss_environment.php**  
 enter your database connection   
 enter your admin username and password to be able to login to the 
 backend
 
* **portfolio/_config/general.yml**  
 form messages (e.g. Blog Entry Comments) are send via phpmailer with smtp authentification. put here your smtp connection data
 
* provide a google api key link to show Locations
 
* **check Permissions:** give the assets folder write permissions
 
* **.htaccess:** maybe you have to edit the .htaccess file - especially RewriteBase.

## Modules
**Static Publisher:**
The module is ready to use. You just need to edit the .htaccess file and uncomment this line: 
`RewriteRule .* staticpublisher/main.php?url=%1&%{QUERY_STRING} [L]` and remove this line: `RewriteRule .* framework/main.php?url=%1&%{QUERY_STRING} [L]`

to create the static cache you have to run this in your browser: /dev/tasks/RebuildStaticCacheTask

make sure the cache folder exists and has permissions to write files

## Common Problems
**Backend White Page / Internal Server Error:**
this can happen after switching SS_ENVIRONMENT_TYPE to 'live'. Make sure the assets folder has write permissions, silverstripe wants to write there the folder _combinedfiles
