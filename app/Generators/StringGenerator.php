<?php


namespace App\Generators;


class StringGenerator implements GeneratorInterface
{
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
        $generatedString = '';
        for ($i = 0; $i < $this->length; $i++) {
            $generatedString .= chr(random_int(0, 255));
        }
        return $generatedString;
    }
}
