<?php
namespace P4\LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class NotClosedDays
 * @package P4\LouvreBundle\Validator
 * @Annotation
 */
class NotClosedDays extends Constraint
{
    public $message = "Le Musée est fermé le mardi et il n'est pas possible de réserver pour le dimanche";
}