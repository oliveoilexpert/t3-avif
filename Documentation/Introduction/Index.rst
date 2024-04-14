.. include:: ../Includes.txt


.. _introduction:

Introduction
============


.. _what-it-does:

What does it do?
----------------

Adds an automatically created _avif_ copy for every processed JPEG or PNG image in the following format.

  original.jpg.avif

What is Avif and why do I want it?
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

  Like WebP, but better ;-)

Drawbacks
---------

Note that this extension produces an additional load on your server (each processed image is reprocessed) and possibly creates a lot of
additional files that consume disk space. Size varies depending on your ImageMagick/GraphicsMagick configuration.

Inspiration
-----------

This extension is a modified version of the `webp <https://extensions.typo3.org/extension/webp/>`_ extension.

