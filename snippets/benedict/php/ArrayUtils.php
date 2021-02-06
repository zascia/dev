<?php

class ArrayUtils {

    /**
     * Removes an element ($value) from the $array
     *
     * @param array $arr
     *            - the array
     * @param mixed $value
     *            - value to be removed
     * @return array: new array
     */
    public static function removeElement($array, $value) {
        return array_values(array_diff($array, array(
            $value
        )));
    }

    /**
     * Takes an array and returns an array of duplicate items //
     */
    public static function getDuplicates($array) {
        return array_unique(array_diff_assoc($array, array_unique($array)));
    }

    public static function toHTMLTable($array) {
        $html .= "<table>";
        foreach ($array as $key => $row) {
            $html .= "<tr>";
            if (is_array($row)) {
                foreach ($row as $key2 => $row2) {
                    $html .= "<td>" . $key2 . "</td>";
                    $html .= "<td>" . $row2 . "</td>";
                }
            } else {
                $html .= "<td>" . $key . "</td>";
                $html .= "<td>" . $row . "</td>";
            }
            $html .= "</tr>";
        }
        $html .= "</table>";

        return $html;
    }

    public static function hasContent($array) {
        return (ArrayUtils::arraySize($array) > 0);
    }

    public static function arraySize($array) {
        if (isset($array) && is_array($array) && ! is_object($array)) {
            return count($array);
        }

        return 0;
    }

    public static function in_arrayi($needle, $array) {
        if (ArrayUtils::hasContent($array)) {
            foreach ($array as $value) {
                if (StringUtils::isEqualIgnoreCase($value, $needle)) {
                    return true;
                }
            }
        }

        return false;
    }

    public static function getFirstElement($array) {
        if (is_array($array)) {
            foreach ($array as $value) {
                return $value;
            }
        }
    }


    /**
     *
     * @param array $array
     * @param string $key
     * @param mixed $value
     * @param boolean $strict
     *
     * @return array - elements matched
     */
    public static function searchKeyValue($array, $key, $value, $strict = false) {
        $arrIt = new RecursiveIteratorIterator(new RecursiveArrayIterator($array));

        $outputArray = array();
        foreach ($arrIt as $sub) {
            $subArray = $arrIt->getSubIterator();
            if (! array_key_exists($key, $subArray)) {
                continue;
            }
            if ($strict) {
                if ($subArray[$key] === $value) {
                    $outputArray[] = iterator_to_array($subArray);
                }
            } else {
                if (is_string($value)) {
                    if (StringUtils::isEqualIgnoreCase($subArray[$key], $value)) {
                        $outputArray[] = iterator_to_array($subArray);
                    }
                } else {
                    if ($subArray[$key] == $value) {
                        $outputArray[] = iterator_to_array($subArray);
                    }
                }
            }
        }

        return $outputArray;
    }

    /**
     * extract an array from $array based on the $keys 
     * @param array $array
     * @param array $keys
     * @return array
     */
    public static function array_slice_assoc($array, $keys) {
        return array_intersect_key($array, array_flip($keys));
    }
}