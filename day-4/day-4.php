<?php

/**
 * Class PassportProcessing
 */
class PassportProcessing {
    private string $input;
    private array $passports = [];
    public array $requiredFields;

    /**
     * PassportProcessing constructor.
     */
    public function __construct()
    {
        $this->input = file_get_contents('input.txt');
        $this->passportInput = explode("\n\n", $this->input);
        $this->requiredFields = [
            'byr',
            'iyr',
            'eyr',
            'hgt',
            'hcl',
            'ecl',
            'pid'
        ];

        $this->parsePassports();
    }

    /**
     * @return array
     */
    function parsePassports()
    {

        foreach ($this->passportInput as $passport) {
            $passportArray = explode(' ', str_replace("\n", ' ', $passport));
            $fields = array_map(fn ($field) => explode(':', $field)[0], $passportArray);
            $values = array_map(fn ($value) => explode(':', $value)[1], $passportArray);
            $data = array_combine($fields, $values);
            array_push($this->passports, $data);
        }

        return $this->passports;
    }

    /**
     * @return int
     */
    function validPassportCount() : int
    {
        $count = null;
        foreach ($this->passports as $passport)
        {
            if ($this->checkPassportHasRequiredFields($passport)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * @param array $passport
     * @return bool
     */
    private function checkPassportHasRequiredFields(array $passport)
    {
        foreach ($this->requiredFields as $key) {
            if (!array_key_exists($key, $passport)) {
                return false;
            }
        }

        return true;
    }
}

$passportProcessor = new PassportProcessing();
$passportCount = $passportProcessor->validPassportCount();
