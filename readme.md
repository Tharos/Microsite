Microsite example
=================

This repository contains an example of very simple web application based on [Nette Framework](http://nette.org), [Lean Mapper](https://github.com/Tharos/LeanMapper) and Lean [Query libraries](https://github.com/Tharos/LeanQuery).
It is meant to be used mainly for study purposes.

-------

In order to get the application running please:

1. Clone this repository into some empty directory
2. Run `composer install` in that directory
3. Create an empty MySQL database and run `/resources/init-db.sql` script on it
4. Copy `/config/config.server.sample.neon` to `/config/config.server.neon`
5. Update database connection settings in `/config/config.server.neon`
6. Make sure that the web server can write into directories `/log` and `/temp`

And that's all. Now you can use following "entry points":

/--
http://localhost/<pathToApplication>/www/cz - Czech version of the microsite
http://localhost/<pathToApplication>/www/en - English version of the microsite
http://localhost/<pathToApplication>/www/cz/admin - Main contents management of the Czech version
http://localhost/<pathToApplication>/www/en/admin - Main contents management of the English version
\--

In admin you can use username `admin` and password `heslo`.

If you want to switch the application into a *dev* mode, please place empty file named `dev` into `/app/config` directory.

License
-------

MIT

Copyright (c) 2014 Vojtěch Kohout (aka Tharos)
