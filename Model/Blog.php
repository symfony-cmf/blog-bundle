<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Symfony\Cmf\Bundle\BlogBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Blog Model
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class Blog
{
    /**
     * Blog name
     *
     * @var string
     */
    protected $name;

    /**
     * Posts
     *
     * @var ArrayCollection
     */
    protected $posts;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Blog
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Add post
     *
     * @param Post $post
     * @return Blog
     */
    public function addPost(Post $post)
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
        }

        return $this;
    }

    /**
     * Remove post
     *
     * @param Post $post
     * @return Blog
     */
    public function removePost(Post $post)
    {
        if ($this->posts->contains($post)) {
            $this->posts->remove($post);
        }

        return $this;
    }

    /**
     * Get posts
     *
     * @return ArrayCollection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Set posts
     *
     * @param $posts
     * @return $this
     */
    public function setPosts($posts)
    {
        $this->posts = new ArrayCollection();

        foreach ($posts as $post) {
            $this->posts->add($post);
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->name;
    }
}
