<?php
namespace P4\LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class NotClosedTuesday
 * @package P4\LouvreBundle\Validator
 * @Annotation
 */
class NotClosedTuesday extends Constraint
{
    public $message = "Le Musée est fermé le mardi";
}