<?php

namespace P4\LouvreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Booking
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="P4\LouvreBundle\Repository\BookingRepository")
 */
class Booking
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
     * @var Ticket
     * @ORM\OneToMany(targetEntity="P4\LouvreBundle\Entity\Ticket", mappedBy="booking", cascade={"persist"})
     * @Assert\Valid()
     */
    private $tickets;



    /**
     * @var date
     *
     * @ORM\Column(name="visitDate", type="date")
     * @Assert\Date()
     */
    private $visitDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reservationDate", type="datetimetz")
     * @Assert\DateTime()
     */
    private $reservationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="reservationCode", type="string", length=255)
     */
    private $reservationCode;

    /**
     * @var int
     *
     * @ORM\Column(name="ticketsNumber", type="integer")
     * @Assert\Range(min="1",max="20", minMessage="La commande minimum est de 1 ticket", maxMessage="Vous ne pouvez pas
     * commander plus de 20 tickets")
     */
    private $ticketsNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email()
     * @Assert\NotBlank(message="Merci d'indiquer votre adresse email")
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="totalAmount", type="integer")
     */
    private $totalAmount;

    /**
     * @var string
     *
     * @ORM\Column(name="ticketsType", type="string")
     */
    private $ticketsType;


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
     * Set visitDate
     *
     * @param \DateTime $visitDate
     *
     * @return Booking
     */
    public function setVisitDate($visitDate)
    {
        $this->visitDate = $visitDate;

        return $this;
    }

    /**
     * Get visitDate
     *
     * @return \DateTime
     */
    public function getVisitDate()
    {
        return $this->visitDate;
    }

    /**
     * Set reservationDate
     *
     * @param \DateTime $reservationDate
     *
     * @return Booking
     */
    public function setReservationDate($reservationDate)
    {
        $this->reservationDate = $reservationDate;

        return $this;
    }

    /**
     * Get reservationDate
     *
     * @return \DateTime
     */
    public function getReservationDate()
    {
        return $this->reservationDate;
    }

    /**
     * Set reservationCode
     *
     * @param string $reservationCode
     *
     * @return Booking
     */
    public function setReservationCode($reservationCode)
    {
        $this->reservationCode = $reservationCode;

        return $this;
    }

    /**
     * Get reservationCode
     *
     * @return string
     */
    public function getReservationCode()
    {
        return $this->reservationCode;
    }

    /**
     * Set ticketsNumber
     *
     * @param integer $ticketsNumber
     *
     * @return Booking
     */
    public function setTicketsNumber($ticketsNumber)
    {
        $this->ticketsNumber = $ticketsNumber;

        return $this;
    }

    /**
     * Get ticketsNumber
     *
     * @return int
     */
    public function getTicketsNumber()
    {
        return $this->ticketsNumber;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Booking
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set totalAmount
     *
     * @param integer $totalAmount
     *
     * @return Booking
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    /**
     * Get totalAmount
     *
     * @return int
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Set ticketsType
     *
     * @param boolean $ticketsType
     *
     * @return Booking
     */
    public function setTicketsType($ticketsType)
    {
        $this->ticketsType = $ticketsType;

        return $this;
    }

    /**
     * Get ticketsType
     *
     * @return bool
     */
    public function getTicketsType()
    {
        return $this->ticketsType;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tickets = new ArrayCollection();
        $this->reservationDate = new \DateTime();
    }

    /**
     * Add ticket
     *
     * @param \P4\LouvreBundle\Entity\Ticket $ticket
     *
     * @return Booking
     */
    public function addTicket(\P4\LouvreBundle\Entity\Ticket $ticket)
    {
        $this->tickets[] = $ticket;

        return $this;
    }

    /**
     * Remove ticket
     *
     * @param \P4\LouvreBundle\Entity\Ticket $ticket
     */
    public function removeTicket(\P4\LouvreBundle\Entity\Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }

    /**
     * Get tickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTickets()
    {
        return $this->tickets;
    }
}
