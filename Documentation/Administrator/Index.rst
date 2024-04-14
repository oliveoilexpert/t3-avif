.. include:: ../Includes.txt


.. _admin-manual:

Administration Manual
=====================

Target group: **Administrators**

.. _admin-installation:

Requirements
------------

Your version of ImageMagick or GraphicsMagick on the server needs to support WebP.

How to test
^^^^^^^^^^^

You can test the support on the command line:

GraphicsMagick
""""""""""""""

.. code-block:: bash

  gm version | grep avif

This should return "*yes*".

ImageMagick
"""""""""""

.. code-block:: bash

  convert version | grep avif

This should return a list of supported formats including WebP.

Installation
------------

Add via composer.json:

.. code-block:: javascript

  composer require "wapplersystens/avif"


Install and activate the extension in the Extension manager and clear your processed files in the Install Tool or Maintenance module.

.. _admin-configuration:

Configuration
-------------

Extension manager configuration
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

You can set parameters for the conversion in the extension configuration.

.. code-block:: none

  # cat=basic; type=string; label=Avif conversion parameters (for internal or external adapter)
  parameters =

You find a list of possible options here:

:GraphicsMagick: http://www.graphicsmagick.org/GraphicsMagick.html and http://www.graphicsmagick.org/convert.html

Default value is:

.. code-block:: none

  -quality 40 -define avif:lossless=false

This has (in our experience) a minor to no impact on visual difference to the original image.

.. warning::

  Try to set a higher value for quality first if the image does not fit your expectations, before trying to use *avif:lossless=true*.
  This could even lead to a larger filesize than the original!

Web server configuration
^^^^^^^^^^^^^^^^^^^^^^^^

nginx
"""""

Add a map directive in your *global* configuration:

.. code-block:: nginx

  map $http_accept $avif_suffix {
     default   "";
     "~*avif"  ".avif";
  }

And add these rules to your *server* configuration:

.. code-block:: nginx

  location ~* ^/fileadmin/.+\.(png|jpg|jpeg)$ {
          add_header Vary Accept;
          try_files $uri$avif_suffix $uri =404;
  }
  location ~* ^/other-storage/.+\.(png|jpg|jpeg)$ {
          add_header Vary Accept;
          try_files $uri$avif_suffix $uri =404;
  }

Apache (.htaccess example)
""""""""""""""""""""""""""

Add the following lines to the *.htaccess* file of the document root:

.. code-block:: apache

  <IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTP_ACCEPT} image/avif
    RewriteCond %{DOCUMENT_ROOT}/$1.$2.avif -f
    RewriteRule ^(fileadmin/.+)\.(png|jpg|jpeg)$ $1.$2.avif [T=image/avif,E=accept:1]
    RewriteRule ^(other-storage/.+)\.(png|jpg|jpeg)$ $1.$2.avif [T=image/avif,E=accept:1]
  </IfModule>

  <IfModule mod_headers.c>
    Header append Vary Accept env=REDIRECT_accept
  </IfModule>

  AddType image/avif .avif


Make sure that there are no other rules that already apply to the specified image formats and prevent further execution!
