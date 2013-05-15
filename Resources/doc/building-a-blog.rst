Work in progress
================

This document will eventually describe the process of implementing
the BlogBundle.

Routing
-------

Register the routes in config.yml

.. code-block:: php

    symfony_cmf_routing:
        dynamic:
            ...
            controllers_by_class:
                Symfony\Cmf\Bundle\BlogBundle\Document\Blog: symfony_cmf_blog.blog_controller:list
                Symfony\Cmf\Bundle\BlogBundle\Document\Post: symfony_cmf_blog.blog_controller:viewPost
                Symfony\Cmf\Bundle\BlogBundle\Document\Tag: symfony_cmf_blog.blog_controller:list
