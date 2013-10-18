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

Then to update the related silverstripe-modules (googlesitemaps etc.) you have to execute these commands:

`git submodule init`

`git submodule update`

Of course you can download everything manually as well. Keep in mind submodules are not included if you choose 'Download ZIP'.

## Configuration
Edit this files to configure the website and the database connection:

_ss_environment.php

portfolio/_config/general.yml

**Static Publisher:**
The module is ready to use. You just need to edit the .htaccess file and uncomment this line: 
`RewriteRule .* staticpublisher/main.php?url=%1&%{QUERY_STRING} [L]` and remove this line: `RewriteRule .* framework/main.php?url=%1&%{QUERY_STRING} [L]`

to create the static cache you have to run this in your browser: /dev/tasks/RebuildStaticCacheTask
