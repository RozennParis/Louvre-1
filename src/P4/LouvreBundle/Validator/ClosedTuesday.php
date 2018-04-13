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
    public $message = "The museum is closed on Tuesdays";
}