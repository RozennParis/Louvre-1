<?php
namespace P4\LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class NotPossibleBooking
 * @package P4\LouvreBundle\Validator
 * @Annotation
 */
class NotPossibleBooking extends Constraint
{
    /**
     * @var string
     */
    public $message = "Il n'est pas possible de réserver pour les jours fériés";

}