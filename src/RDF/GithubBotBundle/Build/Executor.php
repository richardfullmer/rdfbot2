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
use Symfony\Component\Process\Process;

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
     * @var array
     */
    private $output;

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
        $this->buildsDir = realpath(__DIR__ . '/../../../../app/builds');
    }

    public function execute(Build $build)
    {
        $this->output = '';
        $start = microtime(true);

        // set more stuff on the build object, pull from client
        //$build->set
        $username = $build->getProject()->getUsername();
        $repository = $build->getProject()->getRepository();

        $this->run(sprintf('git clone --depth=100 --quiet git@github.com:%s/%s.git %s/%s', $username, $repository, $username, $repository), $this->buildsDir);
        $this->run(sprintf('cd %s/%s', $username, $repository), $this->buildsDir);

        $repoDir = rtrim($this->buildsDir, '/') . DIRECTORY_SEPARATOR . sprintf('%s/%s', $username, $repository);
        $this->run(sprintf('git checkout -qf %s', $build->getCommitSha()), $repoDir);
        foreach (explode("\n", $build->getProject()->getConfiguration()) as $command) {
            $this->run($command, $repoDir);
        }
        $this->run(sprintf('rm -rf %s/%s', $username, $repository), $this->buildsDir);

        $end = microtime(true);

        $build->setOutput($this->output);
        $build->setFinishedAt(new \DateTime());
        $build->setDuration((int) ($end - $start) / 1000);
        $build->setStatus(Build::STATUS_SUCCESS);
        $this->manager->persist($build);
        $this->manager->flush();
    }

    private function run($command, $cwd, $timeout = 3600)
    {
        $this->output .= '$ ' . $command . "\n";
        print_r('$ ' . $command . "\n");

        $process = new Process(trim($command), $cwd);
        $process->setTimeout($timeout);

        $output = &$this->output;
        $process->run(function($type, $buffer) use (&$output) {
            if ('err' == $type) {
                print_r($buffer);
            } else {
                print_r($buffer);
            }
            $output .= $buffer;
        });

        return $process;
    }
}
