<?php

namespace P4\LouvreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use P4\LouvreBundle\Validator\Thousand;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use P4\LouvreBundle\Validator\NotBeforeTwo;
use P4\LouvreBundle\Validator\NotPossibleBooking;
use P4\LouvreBundle\Validator\ClosedTuesday;
use P4\LouvreBundle\Validator\ClosedSunday;

/**
 * Booking
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="P4\LouvreBundle\Repository\BookingRepository")
 * @NotBeforeTwo(groups={"Booking"})
 * @Thousand(groups={"Booking"})
 */
class Booking
{

    const BOOKING_FULL_DAY = true;
    const BOOKING_HALF_DAY = false;
    const MAX_TICKETS_PER_DAY = 1000;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="P4\LouvreBundle\Entity\Ticket" , mappedBy="booking", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $tickets;

    /**
     * @var \DateTime $visitDate
     *
     * @ORM\Column(name="visitDate", type="datetime")
     * @Assert\Date(groups={"Booking"})
     * @Assert\Range(
     *     min="today",
     *     max="+18 months",
     *     minMessage="you can not book for a date earlier than today",
     *     maxMessage="reservations can only be made for the next 18 months",groups={"Booking"})
     * @ClosedSunday(groups={"Booking"})
     * @ClosedTuesday(groups={"Booking"})
     * @NotPossibleBooking(groups={"Booking"})
     */

    private $visitDate;

    /**
     * @ORM\Column(name="purchaseDate", type="date")
     * @Assert\DateTime(groups={"Booking"})
     */
    private $purchaseDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="ticketType", type="boolean")
     * @Assert\NotNull(groups={"Booking"})
     */
    private $ticketType;

    /**
     * @var int
     *
     * @ORM\Column(name="totalPrice", type="integer")
     */
    private $totalPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="bookingCode", type="string", length=255)
     */
    private $bookingCode;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\NotBlank(groups={"Booking"})
     * @Assert\Email(groups={"Booking"})
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="nbTickets", type="integer")
     */
    private $nbTickets;


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
     * Set purchaseDate
     *
     * @param \DateTime $purchaseDate
     *
     * @return Booking
     */
    public function setPurchaseDate($purchaseDate)
    {
        $this->purchaseDate = $purchaseDate;

        return $this;
    }

    /**
     * Get purchaseDate
     *
     * @return \DateTime
     */
    public function getPurchaseDate()
    {
        return $this->purchaseDate;
    }

    /**
     * Set ticketType
     *
     * @param boolean $ticketType
     *
     * @return Booking
     */
    public function setTicketType($ticketType)
    {
        $this->ticketType = $ticketType;

        return $this;
    }

    /**
     * Get ticketType
     *
     * @return bool
     */
    public function getTicketType()
    {
        return $this->ticketType;
    }

    public function getTicketTypeLabel(){
        return $this->ticketType ? "day" : "half-day";
    }


    /**
     * Set totalPrice
     *
     * @param integer $totalPrice
     *
     * @return Booking
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Get totalPrice
     *
     * @return int
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * Set bookingCode
     *
     * @param string $bookingCode
     *
     * @return Booking
     */
    public function setBookingCode($bookingCode)
    {
        $this->bookingCode = $bookingCode;

        return $this;
    }

    /**
     * Get bookingCode
     *
     * @return string
     */
    public function getBookingCode()
    {
        return $this->bookingCode;
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
     * Set nbTickets
     *
     * @param integer $nbTickets
     *
     * @return Booking
     */
    public function setNbTickets($nbTickets)
    {
        $this->nbTickets = $nbTickets;

        return $this;
    }

    /**
     * Get nbTickets
     *
     * @return int
     */
    public function getNbTickets()
    {
        return $this->nbTickets;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tickets = new ArrayCollection();
        $this->purchaseDate = new\DateTime();
        //$this->visitDate = new \DateTime();
    }

    /**
     * Add ticket
     *
     * @param Ticket $ticket
     *
     * @return Booking
     */
    public function addTicket(Ticket $ticket)
    {
        $this->tickets[] = $ticket;
        $ticket->setBooking($this);

        return $this;
    }

    /**
     * Remove ticket
     *
     * @param Ticket $ticket
     */
    public function removeTicket(Ticket $ticket)
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
