[WIP] Symfony Cmf Blog Bundle
=============================

This is part of the Symfony Cmf: <https://github.com/symfony-cmf/symfony-cmf>

## About

The blog bundle is a very much "work in progress" and will only be complete
when all the necessary pieces of the CMF are available.

The missing pieces:

* **TaxonomyBundle**: for tagging
* **phpcr-odm/something-else**: Way to automatically order nodes when saving
  (ensure next / previous posts are indeed the next and previous posts
  according to date)

Currently implemented:

* **PublishWorkFlowChecker**: The PWFC from the CoreBundle handles the
  publication status of blog posts.

## Links

- GitHub: <https://github.com/symfony-cmf/symfony-cmf>
- Sandbox: <https://github.com/symfony-cmf/cmf-sandbox>
- Web: <http://cmf.symfony.com/>
- Wiki: <http://github.com/symfony-cmf/symfony-cmf/wiki>
- Issue Tracker: <http://cmf.symfony-project.org/redmine/>
- IRC: irc://freenode/#symfony-cmf
- Users mailing list: <http://groups.google.com/group/symfony-cmf-users>
- Devs mailing list: <http://groups.google.com/group/symfony-cmf-devs>

## Documentation

http://symfony.com/doc/master/cmf/bundles/blog.html
