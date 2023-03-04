<?php

interface TimeToWordConvertingInterface
{
    public function convert(int $hours, int $minutes): string;
}

class TimeToWords implements TimeToWordConvertingInterface
{
    public string $timeToString;

    public function convert(int $hours, int $minutes):string
    {
        if ($minutes == 0)
        {
            $this->timeToString = $this->getWordRoot($hours);

            match ($hours)
            {
                1       => $this->timeToString .= 'ин',
                2       => $this->timeToString .= 'а',
                default => $this->timeToString .= $this->addEnding($hours),
            };

            match ($hours)
            {
                1       => $this->timeToString .= ' час.',
                2, 3, 4 => $this->timeToString .= ' часа.',
                default => $this->timeToString .= 'часов.',
            };

            return ucfirst($this->timeToString);
        }
        elseif ($minutes == 15 || $minutes == 30 || $minutes == 45)
        {
            $end = match ($hours)
            {
                1       => 'ин',
                2       => 'а',
                default => $this->addEnding($hours),
            };

            return match ($minutes)
            {
                15 => 'Четверть' . ' ' . $this->getGenitive($hours) . '.',
                30 => 'Половина' . ' ' . $this->getGenitive($hours) . '.',
                45 => 'Без четверти' . ' ' . $this->getWordRoot($hours) . $end . '.',
            };
        }
        else
        {
            $after30     = false;
            $after30Word = 'после ';

            if($minutes > 30)
            {
                $after30     = true;
                $after30Word = 'до ';
            }

            $moreThen20 = $after30 ? (($minutes - 30) < 10 ? 'Двадцать ' : '') : ($minutes > 20 ? 'Двадцать ' : '');

            $minutes = $after30 ? (($minutes - 30) < 10 ?  10 - ($minutes - 30) : 60 - $minutes) : (($minutes > 20) ? $minutes % 20 : $minutes);

            $this->timeToString = $moreThen20 . $this->getWordRoot($minutes) . $this->addEnding($minutes);

            $this->timeToString .= ' ' . $this->getMinutesAsWord($minutes) . ' ' . $after30Word .  $this->getGenitive($hours);

            return ucfirst($this->timeToString) . '.';
        }
    }

    public function getMinutesAsWord(int $min): string
    {
         return match ($min)
            {
                1       => 'минута',
                2, 3, 4 => 'минуты',
                default => 'минут',
            };
    }

    public function addEnding(int $int):string
    {
        return match ($int) {
            1       => 'на',
            2, 4    => 'е',
            3       => 'и',
            default => 'ь',
        };
    }

    public function getWordRoot(int $int): string
    {
        $intToString = '';

        switch ($int)
        {
            case 1:
                $intToString = 'од';
                break;
            case 2:
                $intToString = 'дв';
                break;
            case 3:
                $intToString = 'тр';
                break;
            case 4:
                $intToString = 'четыр';
                break;
            case 5:
                $intToString = 'пят';
                break;
            case 6:
                $intToString = 'шест';
                break;
            case 7:
                $intToString = 'сем';
                break;
            case 8:
                $intToString = 'вос';
                break;
            case 9:
                $intToString = 'девят';
                break;
            case 10:
                $intToString = 'десят';
                break;
            case 11:
                $intToString = 'одиннадцат';
                break;
            case 12:
                $intToString = 'двенадцат';
                break;
            case 13:
                $intToString = 'тринадцат';
                break;
            case 14:
                $intToString = 'четырнадцат';
                break;
            case 16:
                $intToString = 'шестнадцат';
                break;
            case 17:
                $intToString = 'семнадцат';
                break;
            case 18:
                $intToString = 'восемнадцат';
                break;
            case 19:
                $intToString = 'девятнадцат';
                break;
            case 20:
                $intToString = 'двадцат';
                break;
        }

        return $intToString;
    }

    public function getGenitive(int $int): string
    {
        $intToString = '';

        switch ($int)
        {
            case 1:
                $intToString = 'первого';
                break;
            case 2:
                $intToString = 'второго';
                break;
            case 3:
                $intToString = 'третьего';
                break;
            case 4:
                $intToString = 'четвертого';
                break;
            case 5:
                $intToString = 'пятого';
                break;
            case 6:
                $intToString = 'шестого';
                break;
            case 7:
                $intToString = 'седьмого';
                break;
            case 8:
                $intToString = 'восьмого';
                break;
            case 9:
                $intToString = 'девятого';
                break;
            case 10:
                $intToString = 'десятого';
                break;
            case 11:
                $intToString = 'одиннадцатого';
                break;
            case 12:
                $intToString = 'двенадцатого';
                break;
        }

        return $intToString;
    }
}

$hours   = intval(readline("h = "));
$minutes = intval(readline("m = "));

$time = new TimeToWords();
echo $time->convert($hours, $minutes);
