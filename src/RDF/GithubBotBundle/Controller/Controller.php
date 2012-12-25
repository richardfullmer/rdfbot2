<?php

namespace RDF\GithubBotBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

class Controller extends BaseController
{

    /**
     * @return \Github\Client
     */
    public function getGithubClient()
    {
        return $this->container->get('rdf_github_bot.github_client');
    }

}
