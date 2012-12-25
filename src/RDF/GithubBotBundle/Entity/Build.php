<?php

namespace RDF\GithubBotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Build
 *
 * @ORM\Table(name="build")
 * @ORM\Entity(repositoryClass="RDF\GithubBotBundle\Entity\Repository\BuildRepository")
 */
class Build
{
    const STATUS_SUCCESS = 0;
    const STATUS_FAILED = 1;
    const STATUS_ERROR = 2;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="Project")
     */
    private $project;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="commit_sha", type="string", length=255)
     */
    private $commit_sha;

    /**
     * @var string
     *
     * @ORM\Column(name="branch", type="string", length=255)
     */
    private $branch;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="committer", type="string", length=255)
     */
    private $committer;

    /**
     * @var string
     *
     * @ORM\Column(name="output", type="text")
     */
    private $output;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="finished_at", type="datetime")
     */
    private $finished_at;

    /**
     * @var integer
     *
     * @ORM\Column(name="duration", type="integer")
     */
    private $duration;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set Project
     *
     * @param Project $project
     * @return Build
     */
    public function setProject(Project $project)
    {
        $this->project = $project;
    
        return $this;
    }

    /**
     * Get Project
     *
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Build
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set commit_sha
     *
     * @param string $commitSha
     * @return Build
     */
    public function setCommitSha($commitSha)
    {
        $this->commit_sha = $commitSha;
    
        return $this;
    }

    /**
     * Get commit_sha
     *
     * @return string 
     */
    public function getCommitSha()
    {
        return $this->commit_sha;
    }

    /**
     * Set branch
     *
     * @param string $branch
     * @return Build
     */
    public function setBranch($branch)
    {
        $this->branch = $branch;
    
        return $this;
    }

    /**
     * Get branch
     *
     * @return string 
     */
    public function getBranch()
    {
        return $this->branch;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Build
     */
    public function setMessage($message)
    {
        $this->message = $message;
    
        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Build
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    
        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set committer
     *
     * @param string $committer
     * @return Build
     */
    public function setCommitter($committer)
    {
        $this->committer = $committer;
    
        return $this;
    }

    /**
     * Get committer
     *
     * @return string 
     */
    public function getCommitter()
    {
        return $this->committer;
    }

    /**
     * Set output
     *
     * @param string $output
     * @return Build
     */
    public function setOutput($output)
    {
        $this->output = $output;
    
        return $this;
    }

    /**
     * Get output
     *
     * @return string 
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Set finished_at
     *
     * @param \DateTime $finishedAt
     * @return Build
     */
    public function setFinishedAt($finishedAt)
    {
        $this->finished_at = $finishedAt;
    
        return $this;
    }

    /**
     * Get finished_at
     *
     * @return \DateTime 
     */
    public function getFinishedAt()
    {
        return $this->finished_at;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     * @return Build
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    
        return $this;
    }

    /**
     * Get duration
     *
     * @return integer 
     */
    public function getDuration()
    {
        return $this->duration;
    }
}
