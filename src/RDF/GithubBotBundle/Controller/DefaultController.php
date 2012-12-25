<?php

namespace RDF\GithubBotBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{

    /**
     * @Route("/")
     * @Template
     */
    public function homepageAction()
    {
        return array();
    }

    /**
     * @Route("/_project_list")
     * @Template
     */
    public function projectListAction()
    {
        return array(
            'projects' => $this->getDoctrine()->getRepository('RDFGithubBotBundle:Project')->findAll()
        );
    }

    /**
     * @Route("/{username}/{repository}")
     * @Template
     */
    public function projectAction($username, $repository)
    {
        $project = $this->getDoctrine()->getRepository('RDFGithubBotBundle:Project')->findOneByUsernameAndRepository($username, $repository);

        if (null === $project) {
            throw $this->createNotFoundException("Unknown Project");
        }

        $client = $this->getGithubClient();

        $pullRequests = $client->api('pull_request')->all($username, $repository);
        $branches = $client->api('repos')->branches($username, $repository);

        return array(
            'project' => $project,
            'pullRequests' => $pullRequests,
            'branches' => $branches
        );
    }


    /**
     * @Route("/{username}/{repository}/trigger")
     */
    public function triggerAction($username, $repository)
    {
        $project = $this->getDoctrine()->getRepository('RDFGithubBotBundle:Project')->findOneByUsernameAndRepository($username, $repository);

        if (null === $project) {
            throw $this->createNotFoundException("Unknown Project");
        }

        $client = $this->getGithubClient();

        try {
            $branches = $client->api('repos')->branches($username, $repository);
        } catch (\RuntimeException $e) {
            print_r($client->getHttpClient()->getLastRequest());
        }

        print_r($branches);

        return new Response('OK');
    }

    /**
     * @Route("/{username}/{repository}/builds/{id}")
     * @Template
     */
    public function buildAction($username, $repository, $id)
    {

        $project = $this->getDoctrine()->getRepository('RDFGithubBotBundle:Project')->findOneByUsernameAndRepository($username, $repository);

        if (null === $project) {
            throw $this->createNotFoundException("Unknown Project");
        }

        $build = $this->getDoctrine()->getRepository('RDFGithubBotBundle:Build')->findByProjectAndId($project, $id);

        if (null === $build) {
            throw $this->createNotFoundException("Unknown build for this project");
        }

        return array(
            'project' => $project,
            'build' => $build
        );
    }


}
