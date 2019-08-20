<?php


namespace App\Generators;


class IntegerGenerator implements IGenerator
{
    const MAX_LENGTH = 19;

    /**
     * @var integer
     */
    private $length = self::MAX_LENGTH;

    /**
     * @param $length
     */
    public function setLength(int $length)
    {
        if ($length < 1 || $length > self::MAX_LENGTH) {
            throw new \UnexpectedValueException(sprintf('Length must be in range [1, %s]', self::MAX_LENGTH));
        }
        $this->length = $length;
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function generate()
    {
        $min = -(10**$this->length - 1);
        $max = 10**$this->length - 1;
        return random_int($min, $max);
    }
}