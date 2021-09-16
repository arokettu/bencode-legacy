<?php

declare(strict_types=1);

namespace SandFox\Bencode;

final class Decoder
{
    private $options;

    public function __construct(array $options = [])
    {
        if (isset($options['dictionaryType'])) {
            $options['dictType'] = $options['dictType'] ?? $options['dictionaryType'];
        }

        if (isset($options['useGMP']) && $options['useGMP']) {
            $options['bigInt'] = $options['bigInt'] ?? Bencode\BigInt::GMP;
        }

        $this->options = $options;
    }

    /**
     * Decode bencoded data from stream
     *
     * @param resource $readStream Read capable stream
     * @return mixed
     */
    public function decodeStream($readStream)
    {
        return (new Engine\Decoder($readStream, $this->options))->decode();
    }

    /**
     * Decode bencoded data from string
     *
     * @param string $bencoded
     * @return mixed
     */
    public function decode(string $bencoded)
    {
        $stream = fopen('php://temp', 'r+');
        fwrite($stream, $bencoded);
        rewind($stream);

        $decoded = self::decodeStream($stream);

        fclose($stream);

        return $decoded;
    }

    /**
     * Load data from bencoded file
     *
     * @param string $filename
     * @return mixed
     */
    public function load(string $filename)
    {
        $stream = fopen($filename, 'r');

        if ($stream === false) {
            return false;
        }

        $decoded = self::decodeStream($stream);

        fclose($stream);

        return $decoded;
    }
}
