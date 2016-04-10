# Introduction
This is a api for managing gigs, orders and venues for bands, especially my own band lieber anders!

# Installation
To be written

# Building
Use `php composer.phar install` to install all dependencies.[Composer]

Use `vendor/bin/propel sql:build` to generate sql maps.[Propel]

Use `vendor/bin/probel model:build` to generate the ORM-Objects.

Use `vendor/bin/probel config:convert` to generate the Database Connection files.

Use `php composer.phar dump-autoload` to generate the autoload scripts.


# License
This software is licenced under GPLv2.

#Credits
Credits go to:
+ Slim[Slim]
+ Propel[Propel]

#Links
[Slim]: http://www.slimframework.com/ "Slim"
[Propel]: http://propelorm.org/ "Propel"