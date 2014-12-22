<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Symfony\Cmf\Bundle\BlogBundle\Tests\Resources\DataFixtures\PHPCR;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Symfony\Cmf\Bundle\BlogBundle\Doctrine\Phpcr\Blog;
use Symfony\Cmf\Bundle\BlogBundle\Doctrine\Phpcr\Post;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadBlogData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        $rootNode = $manager->find(null, $this->getBasePath());

        $numBlogs = 5;
        $numPostsPerBlog = (2 * $this->getPostsPerPage()) + 2; // 3 pages

        $blogIdx = 0;
        while ($blogIdx++ < $numBlogs) {
            $blog = new Blog();
            $blog->setName($faker->sentence(3));
            $blog->setDescription(implode("\n\n", $faker->paragraphs(3)));
            $blog->setParentDocument($rootNode);

            $manager->persist($blog);

            $postIdx = 0;
            while ($postIdx++ < $numPostsPerBlog) {
                $paragraphs = $faker->paragraphs(5);
                $post = new Post();
                $post->setBlog($blog);
                $post->setTitle($faker->sentence(5));
                $post->setBodyPreview($paragraphs[0]);
                $post->setBody(implode("\n\n", $paragraphs));

                $manager->persist($post);
            }
        }
        $manager->flush();
    }

    protected function getPostsPerPage()
    {
        $postsPerPage = $this->container->getParameter('cmf_blog.pagination.posts_per_page');

        return $postsPerPage != 0 ? $postsPerPage : 5;
    }

    protected function getBasePath()
    {
        return $this->container->getParameter('cmf_blog.blog_basepath');
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
