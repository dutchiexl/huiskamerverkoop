<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VisitingDay
 *
 * @ORM\Table(name="visiting_day")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VisitingDayRepository")
 */
class VisitingDay
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="day", type="date")
     */
    private $day;

    /**
     * @ORM\OneToMany(targetEntity="VisitDayHour", mappedBy="visitingDay")
     */
    private $visitDayHours;

    function __toString()
    {
        return $this->getDay()->format("d-m-Y");
    }


    //<editor-fold desc="Generated Getters/Setters">
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set day
     *
     * @param \DateTime $day
     *
     * @return VisitingDay
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return \DateTime
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @return mixed
     */
    public function getVisitDayHours()
    {
        return $this->visitDayHours;
    }

    /**
     * @param mixed $visitDayHours
     */
    public function setVisitDayHours($visitDayHours)
    {
        $this->visitDayHours = $visitDayHours;
    }
    //</editor-fold>
}

