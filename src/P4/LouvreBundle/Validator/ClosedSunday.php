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
    public $message = "Il n'est pas possible de réserver pour le Dimanche";
}