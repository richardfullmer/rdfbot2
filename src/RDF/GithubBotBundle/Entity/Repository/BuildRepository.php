<?php
/*
 *
 */

namespace RDF\GithubBotBundle\Entity\Repository;

use RDF\GithubBotBundle\Entity\Project;
use RDF\GithubBotBundle\Entity\Build;
use Doctrine\ORM\EntityRepository;

/**
 * @author Richard Fullmer <richard.fullmer@opensoftdev.com>
 */
class BuildRepository extends EntityRepository
{

    /**
     * @param Project $project
     * @param integer $id
     * @return null|Build
     */
    public function findByProjectAndId(Project $project, $id)
    {
        return $this->findOneBy(array('project' => $project->getId(), 'id' => $id));
    }
}
