<?php

/**
 * Implementation of function json_decode on PHP
 *
 * @author Alexander Muzychenko
 * @link https://github.com/alexmuz/php-json
 * @see http://php.net/json_decode
 * @license GNU Lesser General Public License (LGPL) http://www.gnu.org/copyleft/lesser.html
 */
if (!function_exists('json_decode')) {

    function json_decode_object($json, $i, $assoc)
    {
        $result = $assoc ? array() : new stdClass();
        $n = strlen($json);
        if ($json[$i] === '{') {
            $i++;
            while ($i < $n && $json[$i] && $json[$i] <= ' ') $i++;
            if ($json[$i] === '}') {
                $i++;
                return $result;
            }
            while ($i < $n) {
                $key = json_decode_string($json, $i);
                while ($i < $n && $json[$i] && $json[$i] <= ' ') $i++;
                if ($json[$i++] != ':') {
                    throw new Exception(":");
                }
                if ($assoc) {
                    $result[$key] = json_decode_value($json, $i, $assoc);
                } else {
                    $result->$key = json_decode_value($json, $i, $assoc);
                }
                while ($i < $n && $json[$i] && $json[$i] <= ' ') $i++;
                if ($json[$i] === '}') {
                    $i++;
                    return $result;
                }
                if ($json[$i++] != ',') {
                    throw new Exception(",");
                }
                while ($i < $n && $json[$i] && $json[$i] <= ' ') $i++;
            }
        }
    }

    function json_decode_array(&$json, &$i, $assoc)
    {
        $result = array();
        $n = strlen($json);
        if ($json[$i] === '[') {
            $i++;
            while ($i < $n && $json[$i] && $json[$i] <= ' ') $i++;
            if ($json[$i] === ']') {
                return array();
            }
            while ($i < $n) {
                $result[] = json_decode_value($json, $i, $assoc);
                while ($i < $n && $json[$i] && $json[$i] <= ' ') $i++;
                if ($json[$i] === ']') {
                    $i++;
                    return $result;
                }
                if ($json[$i++] != ',') {
                    throw new Exception(",");
                }
                while ($i < $n && $json[$i] && $json[$i] <= ' ') $i++;
            }
        }
    }

    function json_decode_string(&$json, &$i)
    {
        $result = '';
        $n = strlen($json);
        if ($json[$i] === '"') {
            while (++$i < $n) {
                if ($json[$i] === '"') {
                    $i++;
                    return $result;
                } elseif ($json[$i] === '\\') {
                    $i++;
                    if ($json[$i] === 'u') {
                        $code = "&#".hexdec(substr($json, $i + 1, 4)).";";
                        $convmap = array(0x80, 0xFFFF, 0, 0xFFFF);
                        $result .= mb_decode_numericentity($code, $convmap, 'UTF-8');
                        $i += 4;
                    } else {
                        break;
                    }
                } else {
                    $result .= $json[$i];
                }
            }
        }
    }

    function json_decode_number(&$json, &$i)
    {
        $result = '';
        if ($json[$i] === '-') {
            $result = '-';
            $i++;
        }
        $n = strlen($json);
        while ($i < $n && $json[$i] >= '0' && $json[$i] <= '9') {
            $result .= $json[$i++];
        }
        
        if ($json[$i] === '.') {
            $result += '.';
            $i++;
            while ($i < $n && $json[$i] >= '0' && $json[$i] <= '9') {
                $result .= $json[$i++];
            }
        }
        if ($json[$i] === 'e' || $json[$i] === 'E') {
            $result .= $json[$i];
            $i++;
            if ($json[$i] === '-' || $json[$i] === '+') {
                $result .= $json[$i++];
            }
            while ($i < $n && $json[$i] >= '0' && $json[$i] <= '9') {
                $result .= $json[$i++];
            }
        }        
         
        return (0 + $result);
    }

    function json_decode_value(&$json, &$i, $assoc = false)
    {
        $n = strlen($json);
        while ($i < $n && $json[$i] && $json[$i] <= ' ') $i++;

        switch ($json[$i]) {
            case '{':
                return json_decode_object($json, $i, $assoc);
            case '[':
                return json_decode_array($json, $i, $assoc);
            case '"':
                return json_decode_string($json, $i);
            case '-':
                return json_decode_number($json, $i);
            case 't':
                 if ($i + 3 < $n && substr($json, $i, 4) === 'true') {
                     $i += 4;
                     return true;
                 }
            case 'f':
                 if ($i + 4 < $n && substr($json, $i, 5) === 'false') {
                     $i += 5;
                     return false;
                 }
            case 'n':
                 if ($i + 3 < $n && substr($json, $i, 4) === 'null') {
                     $i += 4;
                     return null;
                 }            
            default:
                if ($json[$i] >= '0' && $json[$i] <= '9') {
                    return json_decode_number($json, $i);
                } else {
                    throw new Exception("Syntax error");
                };
        }
    }

    function json_decode($json, $assoc = false)
    {
        $i = 0;
        $n = strlen($json);
        try {
            $result = json_decode_value($json, $i, $assoc);
            while ($i < $n && $json[$i] && $json[$i] <= ' ') $i++;
            if ($i < $n) {
                return null;
            }
            return $result;
        } catch (Exception $e) {
            return null;
        }
    }
}
