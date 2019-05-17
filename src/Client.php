<?php

declare(strict_types=1);

namespace SimpleTwilio;

class Client
{
    /** @var \Twilio\Rest\Client */
    private $client;

    /**
     * @throws \Twilio\Exceptions\ConfigurationException
     */
    public function __construct(string $twilioAcccountId, string $twilioAuthToken)
    {
        $this->client = new \Twilio\Rest\Client($twilioAcccountId, $twilioAuthToken);
    }

    public function send(string $from, string $to, string $text, bool $useAsciiSet = true) : bool
    {
        $from = preg_replace("/[(,),\-,\s]/", "", $from);
        if ($from === null) {
            throw new \RuntimeException('Unable to remove invalid characters');
        }

        $to = preg_replace("/[(,),\-,\s]/", "", $to);
        if ($to === null) {
            throw new \RuntimeException('Unable to remove invalid characters');
        }

        if ($useAsciiSet) {
            $text = $this->convertToAsciiSet($text);
        }

        $this->client->messages->create($to, ['from' => $from, 'body' => $text]);

        return true;
    }

    /**
     * Swap incompatible characters with compatible ones.
     * Ex: Swaps [ã | à | á] with [a]
     */
    private function convertToAsciiSet(string $text) : string
    {
        $unwanted_array = [
            'Š' => 'S',
            'š' => 's',
            'Ž' => 'Z',
            'ž' => 'z',
            'À' => 'A',
            'Á' => 'A',
            'Â' => 'A',
            'Ã' => 'A',
            'Ä' => 'A',
            'Å' => 'A',
            'Æ' => 'A',
            'Ç' => 'C',
            'È' => 'E',
            'É' => 'E',
            'Ê' => 'E',
            'Ë' => 'E',
            'Ì' => 'I',
            'Í' => 'I',
            'Î' => 'I',
            'Ï' => 'I',
            'Ñ' => 'N',
            'Ò' => 'O',
            'Ó' => 'O',
            'Ô' => 'O',
            'Õ' => 'O',
            'Ö' => 'O',
            'Ø' => 'O',
            'Ù' => 'U',
            'Ú' => 'U',
            'Û' => 'U',
            'Ü' => 'U',
            'Ý' => 'Y',
            'Þ' => 'B',
            'ß' => 'Ss',
            'à' => 'a',
            'á' => 'a',
            'â' => 'a',
            'ã' => 'a',
            'ä' => 'a',
            'å' => 'a',
            'æ' => 'a',
            'ç' => 'c',
            'è' => 'e',
            'é' => 'e',
            'ê' => 'e',
            'ë' => 'e',
            'ì' => 'i',
            'í' => 'i',
            'î' => 'i',
            'ï' => 'i',
            'ð' => 'o',
            'ñ' => 'n',
            'ò' => 'o',
            'ó' => 'o',
            'ô' => 'o',
            'õ' => 'o',
            'ö' => 'o',
            'ø' => 'o',
            'ù' => 'u',
            'ú' => 'u',
            'û' => 'u',
            'ý' => 'y',
            'þ' => 'b',
            'ÿ' => 'y',
        ];

        return strtr($text, $unwanted_array);
    }
}
