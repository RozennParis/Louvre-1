<?php
namespace P4\LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class Thousand
 * @package P4\LouvreBundle\Validator
 * @Annotation()
 */
class Thousand extends Constraint
{

    public $message = "Can not reserve for this day, capacity is reached";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }


}