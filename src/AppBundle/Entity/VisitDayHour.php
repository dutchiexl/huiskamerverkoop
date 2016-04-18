<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VisitDayHour
 *
 * @ORM\Table(name="visit_day_hour")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VisitDayHourRepository")
 */
class VisitDayHour
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
     * @ORM\ManyToOne(targetEntity="VisitingDay", inversedBy="visitDayHours")
     * @ORM\JoinColumn(name="visiting_day", referencedColumnName="id")
     */
    private $visitDay;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime")
     */
    private $time;

    /**
     * @var int
     *
     * @ORM\Column(name="places", type="integer")
     */
    private $places;

    /**
     * @ORM\OneToMany(targetEntity="Subscriber", mappedBy="visit")
     */
    private $subscribers;

    function __toString()
    {
        return $this->time->format('H:i');
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
     * Set time
     *
     * @param \DateTime $time
     *
     * @return VisitDayHour
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set places
     *
     * @param integer $places
     *
     * @return VisitDayHour
     */
    public function setPlaces($places)
    {
        $this->places = $places;

        return $this;
    }

    /**
     * Get places
     *
     * @return int
     */
    public function getPlaces()
    {
        return $this->places;
    }

    /**
     * @return mixed
     */
    public function getVisitDay()
    {
        return $this->visitDay;
    }

    /**
     * @param mixed $visitDay
     */
    public function setVisitDay($visitDay)
    {
        $this->visitDay = $visitDay;
    }

    /**
     * @return mixed
     */
    public function getSubscribers()
    {
        return $this->subscribers;
    }

    /**
     * @param mixed $subscribers
     */
    public function setSubscribers($subscribers)
    {
        $this->subscribers = $subscribers;
    }
    //</editor-fold>
}

