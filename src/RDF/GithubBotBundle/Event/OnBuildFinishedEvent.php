<?php
/*
 * This file is part of ONP
 *
 * Copyright (c) 2012 Farheap Solutions (http://www.farheap.com)
 *
 * The unauthorized use of this code outside the boundaries of
 * Farheap Solutions Inc. is prohibited.
 */

namespace RDF\GithubBotBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use RDF\GithubBotBundle\Entity\Build;

/**
 * @author Richard Fullmer <richard.fullmer@opensoftdev.com>
 */
class OnBuildFinishedEvent extends Event
{
    /**
     * @var \RDF\GithubBotBundle\Entity\Build
     */
    private $build;

    /**
     * @param \RDF\GithubBotBundle\Entity\Build $build
     */
    public function __construct(Build $build)
    {
        $this->build = $build;
    }

    /**
     * @return \RDF\GithubBotBundle\Entity\Build
     */
    public function getBuild()
    {
        return $this->build;
    }
}
