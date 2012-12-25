<?php
/*
 * This file is part of ONP
 *
 * Copyright (c) 2012 Farheap Solutions (http://www.farheap.com)
 *
 * The unauthorized use of this code outside the boundaries of
 * Farheap Solutions Inc. is prohibited.
 */

namespace RDF\GithubBotBundle\MessageQueue;

use RDF\GithubBotBundle\Build\Executor;
use Doctrine\Common\Persistence\ObjectManager;
use RDF\GithubBotBundle\Entity\Build;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Github\Client;

/**
 * @author Richard Fullmer <richard.fullmer@opensoftdev.com>
 */
class BuildConsumer implements ConsumerInterface
{
    /**
     * @var \RDF\GithubBotBundle\Build\Executor
     */
    private $executor;

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $manager;

    /**
     * @param \RDF\GithubBotBundle\Build\Executor        $executor
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function __construct(Executor $executor, ObjectManager $manager)
    {
        $this->executor = $executor;
        $this->manager = $manager;
    }

    /**
     * @param \PhpAmqpLib\Message\AMQPMessage $msg
     */
    public function execute(AMQPMessage $msg)
    {
        $buildRequest = json_decode($msg->body, true);
        print_r($buildRequest);

        $project = $this->manager->find('RDFGithubBotBundle:Project', $buildRequest['project_id']);

        if (!$project) {
            return;
        }

        $build = new Build();
        $build->setProject($project);
        $build->setCommitSha($buildRequest['commit']);
        $build->setBranch($buildRequest['branch']);
        $build->setStatus(Build::STATUS_PENDING);

        $this->manager->persist($build);
        $this->manager->flush();

        $this->executor->execute($build);

        $this->manager->detach($build);

    }

}
