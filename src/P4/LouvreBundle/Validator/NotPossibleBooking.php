<?php
namespace P4\LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class NotPossibleBooking
 * @package P4\LouvreBundle\Validator
 * @Annotation
 */
class NotPossibleBooking extends Constraint
{
    /**
     * @var array
     */
    public $dayClosed = ['01/01','02/04','01/05','08/05','10/05','21/05','14/07','15/08','01/11','11/11','25/12'];

    public $message = "Il n'est pas possible de réserver pour les jours fériés";



}