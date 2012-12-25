<?php
/*
 * This file is part of ONP
 *
 * Copyright (c) 2012 Farheap Solutions (http://www.farheap.com)
 *
 * The unauthorized use of this code outside the boundaries of
 * Farheap Solutions Inc. is prohibited.
 */

namespace RDF\GithubBotBundle\Build;

use Github\Client;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcher;
use RDF\GithubBotBundle\Entity\Build;

/**
 * @author Richard Fullmer <richard.fullmer@opensoftdev.com>
 */
class Executor
{

    /**
     * @var Client
     */
    private $client;

    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @param EventDispatcher $dispatcher
     * @param Client          $client
     * @param ObjectManager   $manager
     */
    public function __construct(EventDispatcher $dispatcher, Client $client, ObjectManager $manager)
    {
        $this->dispatcher = $dispatcher;
        $this->client = $client;
        $this->manager = $manager;
    }

    public function execute(Build $build)
    {


        // set more stuff on the build object, pull from client
        //$build->set
    }
}
