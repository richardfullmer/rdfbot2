<?php

namespace RDF\GithubBotBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
     * @Route("/{username}/{repository}")
     */
    public function projectAction($username, $repository)
    {
        $project = $this->getDoctrine()->getRepository('RDFGithubBotBundle:Project')->findOneByUsernameAndRepository($username, $repository);

        if (null === $project) {
            throw $this->createNotFoundException("Unknown Project");
        }

        return array(
            'project' => $project
        );
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
