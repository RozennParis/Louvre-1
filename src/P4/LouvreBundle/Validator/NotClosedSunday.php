<?php
namespace P4\LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class NotClosedSunday
 * @package P4\LouvreBundle\Validator
 * @Annotation
 */
class NotClosedSunday extends Constraint
{
    public $message = "Il n'est pas possible de réserver pour le Dimanche";
}