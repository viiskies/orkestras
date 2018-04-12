<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
    const PRIORITY_LOW = 0;
    const PRIORITY_MEDIUM = 1;
    const PRIORITY_HIGH = 2;

    const STATUS_PENDING = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_DONE = 2;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    private $priority;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="date")
     */
    private $deadline;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumn(nullable=true)
     */
    private $category;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=128)
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     * @Assert\Choice({0, 1, 2})
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @return mixed
     * @Assert\GreaterThan("today")
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * @return mixed
     * @Assert\Choice({0, 1, 2})
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getPriorityString()
    {
        switch($this->getPriority()) {
            case self::PRIORITY_HIGH:
                return "High";
            case self::PRIORITY_MEDIUM:
                return "Medium";
            case self::PRIORITY_LOW:
                return "Low";
        }
    }

    /**
     * @return mixed
     */
    public function getStatusString()
    {
        switch($this->getStatus()) {
            case self::STATUS_DONE:
                return "Done";
            case self::STATUS_IN_PROGRESS:
                return "In progress";
            case self::STATUS_PENDING:
                return "Pending";
        }
    }

    /**
     * @param mixed $priority
     */
    public function setPriority($priority): void
    {
        $this->priority = $priority;
    }

    /**
     * @param mixed $createAt
     */
    public function setCreateAt($createAt): void
    {
        $this->createAt = $createAt;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @param mixed $deadline
     */
    public function setDeadline($deadline): void
    {
        $this->deadline = $deadline;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }
}
