<?php
/*
 *
 */

namespace RDF\GithubBotBundle\Entity\Repository;

use RDF\GithubBotBundle\Entity\Project;
use RDF\GithubBotBundle\Entity\Branch;
use Doctrine\ORM\EntityRepository;

/**
 * @author Richard Fullmer <richard.fullmer@opensoftdev.com>
 */
class BranchRepository extends EntityRepository
{

    /**
     * @param Project $project
     * @param integer $id
     * @return null|Branch
     */
    public function findByProjectAndId(Project $project, $id)
    {
        return $this->findOneBy(array('project' => $project->getId(), 'id' => $id));
    }
}
