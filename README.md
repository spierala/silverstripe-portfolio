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