<?php


namespace OC\PlatformBundle\Antispam;


class OCAntispam
{
    private $mailer;
    private $locale;
    private $minLength;
    private $hundred;

    public function __construct(\Swift_Mailer $mailer, $locale, $minLength, $hundred)
    {
        $this->mailer = $mailer;
        $this->locale = $locale;
        $this->minLength = (int)$minLength;
        $this->hundred = $hundred;
    }

    /**
     * Demo check for spam (less than 50 chars => spam!)
     *
     * @param string $text
     * @return bool
     */
    public function isSpam($text)
    {
        return strlen($text) < $this->minLength;
    }

    public function getHundred()
    {
        return $this->hundred;
    }
}