<?php

namespace Blendwerk\Mnemo;

/**
 * Turns (large) integers into easier to remember Japanese sounding words and
 * vice versa.
 *
 * This is a port of the Ruby module rufus-mnemo
 * (http://rufus.rubyforge.org/rufus-mnemo/).
 *
 * @link http://github.com/aleksblendwerk/Mnemo
 * @author Alexander Seltenreich <aleks@blendwerk.net>
 */
class Mnemo {
    /**
     * @var array Consonants used in Mnemo words
     */
    static protected $consonants = array(
        'b', 'd', 'g', 'h', 'j', 'k', 'm',
        'n', 'p', 'r', 's', 't', 'z'
    );

    /**
     * @var array Vowels used in Mnemo words
     */
    static protected $vowels = array(
        'a', 'e', 'i', 'o', 'u'
    );

    /**
     * @var array Additional syllables used in Mnemo words
     */
    static protected $additional = array(
        'wa', 'wo', 'ya', 'yo', 'yu'
    );

    /**
     * @var array Syllables and their special replacements
     */
    static protected $special = array(
        'hu' => 'fu',
        'si' => 'shi',
        'ti' => 'chi',
        'tu' => 'tsu',
        'zi' => 'tzu'
    );

    /**
     * @var string Syllable representing negative values, used as a prefix
     */
    static protected $negative = 'wi';

    /**
     * @var array Syllables mapping
     */
    static protected $syllables = array();

    /**
     * Builds the internal list of syllables.
     *
     * @return void
     */
    public static function initialize()
    {
        if (empty(self::$syllables)) {
            $syllables = array();

            foreach (self::$consonants as $consonant) {
                foreach (self::$vowels as $vowel) {
                    $syllables[] = $consonant . $vowel;
                }
            }

            self::$syllables = array_merge($syllables, self::$additional);
        }
    }

    /**
     * Turns the given integer into a Mnemo word.
     *
     * @param integer $integer Integer to turn into a word.
     *
     * @return string The equivalent Mnemo word.
     */
    public static function fromInteger($integer)
    {
        self::initialize();

        if ($integer < 0) {
            return self::$negative . self::fromInteger(abs($integer));
        }

        return self::toSpecial(self::fromIntegerInner($integer));
    }


    /**
     * Alias of {@see Mnemo::fromInteger()}.
     *
     * @param $integer Integer to turn into a word.
     *
     * @return string The equivalent Mnemo word.
     */
    public static function toString($integer)
    {
        return self::fromInteger($integer);
    }

    /**
     * The actual recursive function that turns an integer into its
     * equivalent Mnemo word.
     *
     * @param integer $integer Integer to turn into a word.
     *
     * @return string The equivalent Mnemo word.
     */
    protected static function fromIntegerInner($integer)
    {
        if ($integer == 0) {
            return '';
        }

        $mod = fmod($integer, count(self::$syllables));
        $rest = floor($integer / count(self::$syllables));

        return self::fromIntegerInner($rest) . self::$syllables[$mod];
    }

    /**
     * Check whether a given string is a Mnemo word.
     *
     * @param string $string String to check
     *
     * @return boolean Returns true if the given string is a Mnemo word
     */
    public static function isMnemoWord($string)
    {
        try {
            self::toInteger($string);
        } catch (\UnexpectedValueException $e) {
            return false;
        }

        return true;
    }

    /**
     * Splits a Mnemo word into an array of syllables.
     *
     * @param string $string
     *
     * @return array Returns an array of syllables
     *
     * @throws \UnexpectedValueException when a syllable is not found
     */
    public static function split($string)
    {
        $syllables = array();

        if (strlen($string) > 0) {
            $string = self::fromSpecial($string);
            $parts = str_split($string, 2);

            foreach ($parts as $syllable) {
                if (in_array($syllable, self::$syllables)) {
                    $syllables[] = self::toSpecial($syllable);
                } else {
                    throw new \UnexpectedValueException(
                        sprintf("The syllable %s was not found.", $syllable)
                    );
                }
            }
        }

        return $syllables;
    }

    /**
     * Turns the given Mnemo word into its equivalent integer.
     *
     * @param string $string A Mnemo word
     *
     * @return integer The integer matching the Mnemo word.
     */
    public static function toInteger($string)
    {
        self::initialize();

        return self::toIntegerInner(self::fromSpecial($string));
    }

    /**
     * Alias of {@see Mnemo::toInteger()}.
     *
     * @param string $string A Mnemo word.
     *
     * @return integer The integer matching the Mnemo word.
     */
    public static function fromString($string)
    {
        return self::toInteger($string);
    }

    /**
     * The actual recursive function that turns a given string into its
     * equivalent integer.
     *
     * @param string $string
     *
     * @return integer
     */
    protected static function toIntegerInner($string)
    {
        if (strlen($string) == 0) {
            return 0;
        }

        if (substr($string, 0, 2) == self::$negative) {
            return -1 * self::toIntegerInner(substr($string, 2));
        }

        return count(self::$syllables)
            * self::toIntegerInner(substr($string, 0, -2))
            + self::toNumber(substr($string, -2));
    }

    /**
     * Turns a single syllable into the equivalent integer.
     *
     * @param string $syllable The syllable to convert
     *
     * @return integer The corresponding integer value
     * @throws \UnexpectedValueException when the syllable is not found
     */
    protected static function toNumber($syllable)
    {
        $result = array_search($syllable, self::$syllables);

        if ($result === false) {
            throw new \UnexpectedValueException(
                sprintf("The syllable %s was not found.", $syllable)
            );
        } else {
            return $result;
        }
    }

    /**
     * Replaces several special syllables in a word using a built-in mapping.
     *
     * @param string $string String to transform
     *
     * @return string String with special syllables replaced
     */
    protected static function toSpecial($string)
    {
        return str_replace(
            array_keys(self::$special),
            array_values(self::$special),
            $string
        );
    }

    /**
     * Returns a word with the original syllables restored.
     *
     * @param string $string String to transform
     *
     * @return string String with original syllables restored
     */
    protected static function fromSpecial($string)
    {
        return str_replace(
            array_values(self::$special),
            array_keys(self::$special),
            $string
        );
    }
}
