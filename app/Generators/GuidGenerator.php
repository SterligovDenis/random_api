<?php


namespace App\Generators;


class GuidGenerator implements IGenerator
{
    /**
     * @return string
     * @throws \Exception
     */
    public function generate()
    {
        $guid = [];
        foreach ([4, 2, 2, 8] as $nByte) {
            $guid[] = bin2hex(random_bytes($nByte));
        }
        return implode('-', $guid);
    }
}