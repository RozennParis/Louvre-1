<?php
namespace P4\LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class ClosedSunday
 * @package P4\LouvreBundle\Validator
 * @Annotation
 */
class ClosedSunday extends Constraint
{
    /**
     * @var string
     */
    public $message = "It is not possible to book for Sunday";
}