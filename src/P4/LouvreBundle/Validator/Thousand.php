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

    public $message = "Impossible de réserver pour ce jour , la capacité d'accueil est atteinte";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }


}