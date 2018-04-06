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

    public $message = "Attention vous ne pouvez pas réserver de billet journée après 14 heures ";
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }


}