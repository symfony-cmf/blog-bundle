[WIP] Symfony Cmf Blog Bundle
=============================

Features
--------

- Sonata backoffice admin
- Frontoffice controllers:
  - Blog archive w/pagination (knp-paginator??) and postView
- Tags
  - Support for native PHPCR or ORM, or other strategies.
- Blocks
  - TagCloudBlock
- Very simple structure for now. Blog>Post*
- RSS/ATOM feed

Next?
-----

 - Frontend editing with create.js
  - On blog post page
 - Preview/Leader text for posts, with frontoffice edition.
 - Have dedicated Blog>Posts>Post* folder for posts
 - Or have post repositories, and have Blog with no children
   - E.g. reference a service which can provide a single set of posts
   - Or an aggregation of posts from multiple sets of posts.
 - Create PostInterface and BlogInterface
 - Blog statuses (published, draft, etc)
   - From ODM? Probably.
   - From configuration? Alternatively.
