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
     * @var array
     */

    public $message = "It is not possible to book for public holidays";


}