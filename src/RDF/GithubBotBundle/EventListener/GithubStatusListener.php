<?php
/*
 * This file is part of ONP
 *
 * Copyright (c) 2012 Farheap Solutions (http://www.farheap.com)
 *
 * The unauthorized use of this code outside the boundaries of
 * Farheap Solutions Inc. is prohibited.
 */

namespace RDF\GithubBotBundle\EventListener;

use RDF\GithubBotBundle\Event\OnBuildStartedEvent;
use RDF\GithubBotBundle\Event\OnBuildFinishedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Github\Client;
use RDF\GithubBotBundle\Events;

/**
 * @author Richard Fullmer <richard.fullmer@opensoftdev.com>
 */
class GithubStatusListener implements EventSubscriberInterface
{
    /**
     * @var \Github\Client
     */
    private $client;

    /**
     * @param \Github\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param \RDF\GithubBotBundle\Event\OnBuildStartedEvent $event
     */
    public function onBuildStarted(OnBuildStartedEvent $event)
    {
        $build = $event->getBuild();
        $this->updateGithub($build->getProject()->getUsername(), $build->getProject()->getRepository(), $build->getCommitSha(), $build->getStatusName());
    }

    /**
     * @param \RDF\GithubBotBundle\Event\OnBuildFinishedEvent $event
     */
    public function onBuildFinished(OnBuildFinishedEvent $event)
    {
        $build = $event->getBuild();
        $this->updateGithub($build->getProject()->getUsername(), $build->getProject()->getRepository(), $build->getCommitSha(), $build->getStatusName());
    }

    /**
     * @param $username
     * @param $repo
     * @param $commit
     * @param $status
     */
    private function updateGithub($username, $repo, $commit, $status)
    {
        $this->client->api('repos')->statuses()->create(
            $username,
            $repo,
            $commit,
            array(
                'state' => $status,
                'description' => ucfirst($status) . ' at ' . date('m/d/y G:i:s T'),
//                'target_url' => $url
            )
        );
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::BUILD_STARTED => 'onBuildUpdated',
            Events::BUILD_FINISHED => 'onBuildFinished'
        );
    }

}
