<?php

namespace OC\PlatformBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Antiflood extends Constraint
{
    public $message = "Le message %string% est trop court !";

    // to call this constraint: @Antiflood(message="Mon message personnalisé")
}