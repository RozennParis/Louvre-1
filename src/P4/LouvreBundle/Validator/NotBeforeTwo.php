<?php
namespace P4\LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class NotBeforeTwo
 * @package P4\LouvreBundle\Validator
 * @Annotation
 */
class NotBeforeTwo extends Constraint
{
    /**
     * @var string
     */

    public $message = " you can not book a day ticket after 14 hours ";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

}