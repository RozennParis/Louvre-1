<?php
namespace P4\LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class ClosedTuesday
 * @package P4\LouvreBundle\Validator
 * @Annotation
 */
class ClosedTuesday extends Constraint
{
    /**
     * @var string
     */
    public $message = "Le Musée est fermé le mardi";
}