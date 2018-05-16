## features :

- links are properly translated, including start page
- near all syntax are translated
- very fast
- comparator views help verify translated renders and syntax


## dokuwiki installation :

- download and unzip dokuwiki in any webroot
- access it's URL, open install.php
- complete installation process with the creation of an admin user (necessary to tweak config and install plugins)
then you have auth and admin links at the top
- install the 'xbr' plugin
- in the configuration, change 'renderer_xhtml' to 'xbr'

now you will have better newline handling


## migration tool usage :

- clone this project
- don't forget to create and fill conf.inc.php from EXAMPLE file
- call generate_pages.php in your browser to convert wikini pages to dokuwiki
- you can compare render and syntax side-by-side using render_comparator.php or syntax_comparator.php


## known issues :

- doesn't generate history
- some imbricated syntax are not supported, byt some of them aren't supported by dokywiki (in titles)
