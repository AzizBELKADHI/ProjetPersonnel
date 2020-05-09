<?php

namespace StageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Traineeship
 *
 * @ORM\Table(name="traineeship", indexes={@ORM\Index(name="fk_student_id", columns={"student_id"})})
 * @ORM\Entity(repositoryClass="StageBundle\Repository\TraineeshipRepository")
 */
class Traineeship
{
    /**
     * @var int
     *
     * @ORM\Column(name="idTraineeship", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idTraineeship;

    /**
     * @var string
     *
     * @ORM\Column(name="isFound", type="string", length=255, nullable=true)
     */
    private $isFound;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=255, nullable=true)
     */
    private $company;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startDate", type="date", nullable=true)
     */
    private $startDate;

    /**
     * @var string
     *
     * @ORM\Column(name="duration", type="string", length=255, nullable=true)
     */
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="string", length=255, nullable=true)
     */
    private $note;


    /**
     * @var \Student
     *
     * @ORM\ManyToOne(targetEntity="Student")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="student_id", referencedColumnName="idStudent", onDelete="SET NULL")
     * })
     */
    private $student;


    /**
     * Get idTraineeship
     *
     * @return int
     */
    public function getIdTraineeship()
    {
        return $this->idTraineeship;
    }

    /**
     * Set isFound
     *
     * @param string $isFound
     *
     * @return Traineeship
     */
    public function setIsFound($isFound)
    {
        $this->isFound = $isFound;

        return $this;
    }

    /**
     * Get isFound
     *
     * @return string
     */
    public function getIsFound()
    {
        return $this->isFound;
    }

    /**
     * Set company
     *
     * @param string $company
     *
     * @return Traineeship
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Traineeship
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set duration
     *
     * @param string $duration
     *
     * @return Traineeship
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return string
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Traineeship
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Traineeship
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param \Student $student
     */
    public function setStudent($student)
    {
        $this->student = $student;

        return $this;
    }


    /**
     * @return \Student
     */
    public function getStudent()
    {
        return $this->student;
    }


}

