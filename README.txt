
Carrot Search FoamTree
----------------------

Carrot Search FoamTree is an interactive visualization of hierarchical data
structures, such as groups of documents or network domains. It works very well
with documents or search results clustered using the Lingo3G document clustering
engine.


Contents of this package
------------------------

./carrotsearch.foamtree.js
  FoamTree implementation, required at runtime.

./carrotsearch.foamtree.asserts.js
  Option value validator, useful for development and debugging, not required at runtime.

./carrotsearch.foamtree.util.*.js
  Utility scripts that handle a number of typical programming tasks around FoamTree.

./api/
  Documentation and API examples.

./demos/
  More examples.

./tests/
  Automated functional tests of FoamTree.


Documentation
-------------

Open api/index.html in a modern browser (Chrome or Firefox recommended).

Examples are fully functional when served over the HTTP protocol.
Start up a local HTTP daemon (Java required):

  bin/nhttpd.sh  -p 8080     # (Linux, Mac)
  bin\nhttpd.bat -p 8080     # (Windows)

and open http://localhost:8080 in a browser.


Contact
-------

For further information and support contact Carrot Search: info@carrotsearch.com


Build information
-----------------

Build type    : Carrot Search FoamTree HTML5 (demo variant)
Build version : 3.3.1
Build number  : FOAMTREE-SOFTWARE3-DIST-4
Build time    : Feb 19, 2015
Built by      : bamboo
Build revision: 539436074ab2afff11d45414c08f7312e5b1fcc2/53943607


Carrot Search Confidential
Copyright 2002-2015 Carrot Search


<-- Foamtree with raw tree and snippet -->

To run a foamtree visualization and tree view navigate to /demos/foamtree.php

Download the source file and run it in your loca server(apache)
you can  see the foamtree and tree viewed cluster with sub cluster and their snippet form json input

