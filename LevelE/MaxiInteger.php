<?php

namespace Hackathon\LevelE;

class MaxiInteger
{
    private $value;
    private $reverse;

    public function __construct($value)
    {
        $this->setValue($value);
    }

    /**
     * @FIX : CAN BE UPDATED
     *
     * @param MaxiInteger $other
     * @return $this|MaxiInteger
     */
    public function add(MaxiInteger $other)
    {
        if (is_null($other)) {
            return $this;
        }

        /**
         * You can delete this part of the code
         */
        $maxLength = max(strlen($this->getValue()), strlen($other->getValue()));
        if ($maxLength) {
            $other = $other->fillWithZero($maxLength);
            $this->setValue($this->fillWithZero($maxLength)->getValue());
        }

        return $this->realSum($this, $other);
    }

    /**
     * @TODO
     *
     * @param MaxiInteger $a
     * @param MaxiInteger $b
     * @return MaxiInteger
     */
    private function realSum($a, $b)
    {
        $number1 = $a->getReverse();
        $number2 = $b->getReverse();
        $addition = "";
        $retenue = 0;

        for ($i = 0; ; $i++) {
            if ($number1 === "" && $number2 === "") {
                if ($retenue > 0)
                    $addition .= $retenue;
                break;
            }
            else if ($number1 === "") {
                $addition .= $number2[0] + $retenue;
                $addition .= substr($number2, 1);
                break;
            }
            else if ($number2 === "") {
                $addition .= $number1[0] + $retenue;
                $addition .= substr($number1, 1);
                break;
            }
            else {
                $tempAdd = $number1[0] + $number2[0] + $retenue;
                $retenue = $tempAdd > 9 ? 1 : 0;
                $addition .= $tempAdd % 10;
                $number1 = substr($number1, 1);
                $number2 = substr($number2, 1);
            }
        }

        return new MaxiInteger(strrev($addition));;
    }

    private function setValue($value)
    {
        $this->value = $value;
        $this->reverse = $this->createReverseValue($value);
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getReverse()
    {
        return $this->reverse;
    }

    private function getNthOfMaxiInteger($n)
    {
        return $this->value[$n];
    }
    private function createReverseValue($value)
    {
        return strrev($value);
    }

    private function fillWithZero($totalLength)
    {
        return new self(strrev(str_pad($this->reverse, $totalLength, '0')));
    }
}
