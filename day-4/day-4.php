<?php

/**
 * Class PassportProcessing
 */
class PassportProcessing
{
    private string $input;
    private array $passports = [];
    private array $requiredFields;
    private array $permittedEyeColors;

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

        $this->permittedEyeColors = [
            'amb',
            'blu',
            'brn',
            'gry',
            'grn',
            'hzl',
            'oth'
        ];

        $this->parsePassports();
    }

    /**
     * @return array
     */
    function parsePassports(): array
    {

        foreach ($this->passportInput as $passport) {
            $passportArray = explode(' ', str_replace("\n", ' ', $passport));
            $fields = array_map(fn($field) => explode(':', $field)[0], $passportArray);
            $values = array_map(fn($value) => explode(':', $value)[1], $passportArray);
            $data = array_combine($fields, $values);
            array_push($this->passports, $data);
        }

        return $this->passports;
    }

    /**
     * @return int
     */
    function validPassportCount(): int
    {
        $count = null;
        foreach ($this->passports as $passport) {
            if ($this->checkPassportHasRequiredFields($passport)) {
                if ($this->validatePassport($passport)) {
                    $count++;
                }
            }
        }

        return $count;
    }

    /**
     * @param array $passport
     * @return bool
     */
    private function checkPassportHasRequiredFields(array $passport): bool
    {
        foreach ($this->requiredFields as $key) {
            if (!array_key_exists($key, $passport)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param $passport
     *
     * byr (Birth Year) - four digits; at least 1920 and at most 2002.
     * iyr (Issue Year) - four digits; at least 2010 and at most 2020.
     * eyr (Expiration Year) - four digits; at least 2020 and at most 2030.
     * hgt (Height) - a number followed by either cm or in:
     * If cm, the number must be at least 150 and at most 193.
     * If in, the number must be at least 59 and at most 76.
     * hcl (Hair Color) - a # followed by exactly six characters 0-9 or a-f.
     * ecl (Eye Color) - exactly one of: amb blu brn gry grn hzl oth.
     * pid (Passport ID) - a nine-digit number, including leading zeroes.
     * cid (Country ID) - ignored, missing or not.
     */
    public function validatePassport($passport)
    {
        return
            $this->birthYearValidation($passport['byr']) &&
            $this->eyeColorValidation($passport['ecl']) &&
            $this->hairColorValidation($passport['hcl']) &&
            $this->heightValidation($passport['hgt']) &&
            $this->passportNumberValidation($passport['pid']) &&
            $this->yearIssuedValidation($passport['iyr']) &&
            $this->yearExpiryValidation($passport['eyr']);
    }

    /**
     * @param $birthYear
     * @return bool
     */
    private function birthYearValidation($birthYear)
    {
        return $birthYear >= 1920 && $birthYear <= 2002;
    }

    /**
     * @param $eyeColor
     * @return bool
     */
    private function eyeColorValidation($eyeColor) : bool
    {
         return in_array($eyeColor, $this->permittedEyeColors);
    }

    /**
     * @param $height
     * @return bool
     */
    private function heightValidation($height) : bool
    {
        $unitOfMeasurement = substr($height, -2);
        $height = substr($height, 0, -2);

        if ($unitOfMeasurement === "cm") {
            return $height >= 150 && $height <= 193;
        } elseif ($unitOfMeasurement === "in") {
            return $height >= 59 && $height <= 76;
        }

        return false;
    }

    /**
     * @param $hairColor
     * @return bool
     */
    private function hairColorValidation($hairColor) : bool
    {
        return (bool) preg_match('/^#[0-9a-f]{6}$/', $hairColor);
    }

    /**
     * @param $passportNumber
     * @return bool
     */
    private function passportNumberValidation($passportNumber) : bool
    {
        return strlen($passportNumber) === 9;
    }

    /**
     * @param $yearIssued
     * @return bool
     */
    private function yearIssuedValidation($yearIssued) : bool
    {
        return $yearIssued >= 2010 && $yearIssued <= 2020;
    }

    /**
     * @param $yearExpiry
     * @return bool
     */
    private function yearExpiryValidation($yearExpiry) : bool
    {
        return $yearExpiry >= 2020 && $yearExpiry <= 2030;
    }
}

$time_start = microtime(true);

$passportProcessor = new PassportProcessing();
$passportCount = $passportProcessor->validPassportCount();
echo $passportCount . PHP_EOL;

$time_end = microtime(true);
$execution_time = ($time_end - $time_start);
echo 'Total Execution Time: ' . $execution_time .' Seconds';
