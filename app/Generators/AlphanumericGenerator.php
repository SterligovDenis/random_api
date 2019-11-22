<?php


namespace App\Generators;


class AlphanumericGenerator implements GeneratorInterface
{
    /**
     * @var array
     */
    private $chars = [];

    public function __construct()
    {
        $this->chars = array_merge(
            range(48, 57), // ascii numbers
            range(65, 90), // ascii uppercase letters
            range(97, 122) // ascii lowercase letters
        );
    }

    /**
     * @var integer
     */
    private $length = 256;

    /**
     * @param $length
     */
    public function setLength(int $length)
    {
        if ($length < 1) {
            throw new \UnexpectedValueException('The length must be at least 1.');
        }
        $this->length = $length;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function generate()
    {
        $chars = '';
        for ($i = 0; $i < $this->length; $i++) {
            $chars .= chr($this->chars[array_rand($this->chars)]);
        }
        return $chars;
    }
}
