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
    public $message1 = "Le Musée est fermé le mardi";
    public $message2 = "Il n'est pas possible de réserver pour le Dimanche";



}