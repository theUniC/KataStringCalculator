<?php

class StringCalculator
{
    public function add($operands)
    {
        $delimiter = ",\n";

        $reduce = function (&$result, $next) {
            return $result . $next;
        };

        // Check if the delimiter is specified
        if ('//' == substr($operands, 0, 2)) {
            $operands = substr($operands, 2);
            preg_match_all('/\[(.*(?!\[\]))\]/', $operands, $matches);
            $delimiter = array_reduce($matches[1], $reduce);
            $operands = substr($operands, strlen(array_reduce($matches[0], $reduce)) + 1);
        }

        $result = 0;
        $negativesFound = false;
        $negatives = [];

        if (null !== $operands) {
            $next = strtok($operands, $delimiter);
            while(false !== $next) {
                if (0 > $next) {
                    $negativesFound = true;
                    $negatives[] = $next;
                }

                if ($next <= 1000) {
                    $result += (int) $next;
                }

                $next = strtok($delimiter);
            }
        }

        if ($negativesFound) {
            $exceptionMessage = 'negatives not allowed';
            if (count($negatives) > 1) {
                $exceptionMessage .= ': ' . implode(', ', $negatives);
            }

            throw new InvalidArgumentException($exceptionMessage);
        }

        return $result;
    }
}