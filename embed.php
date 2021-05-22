<?php
// Designed by RKStudio 
// Embed is a variable parser to allow easy embed to pull html files into html structure to not have to escape php
// 

class Embed {
    public function __construct() {
        
    }

    public function callFile($file, $data = []) {
     
        if (!file_exists($file)) {
            die("file at: $file does not exist!");
        }

        $file = file_get_contents($file); // reads file from url or local directory
        preg_match_all( '/{{(.*)}}/', $file, $vars, PREG_PATTERN_ORDER); // Checks for variable patterns of {{ VAR }}

        if (isset($vars[0]) && !empty($vars[0])) {
            
            for($i = 0; $i < count($vars[0]); $i++) {
                $init = (strpos($vars[1][$i], '.') > -1) ? explode('.',trim($vars[1][$i])) : trim($vars[1][$i]);
                if (is_array($init)) {
                    for($l = 1; $l < count($init); $l++) {
                        if (!isset($data[$init[0]])) {
                            
                            // Find the link of what the code was on
                            $line = $this->getLine($file,$vars[0][$i]);

                            // Replaces caller to display error on information
                            $file = str_replace($vars[0][$i], $this->error("$init[0] is not set in data array", $line), $file);
                            break; // Ends for loop execution
                        }

                        if (!isset($data[$init[0]][$init[$l]])) {

                            // Find the link of what the code was on
                            $line = $this->getLine($file,$vars[0][$i]);

                            // Replaces caller to display error on information
                            $file = str_replace($vars[0][$i], $this->error("Call to undefined key of $init[$l] in array $init[0]", $line), $file);
                            break; // Ends for loop execution
                        }

                        $file = str_replace($vars[0][$i], $data[$init[0]][$init[$l]],$file); // Replaces file if valid data is preset
                    }

                } else {

                    if (!isset($data[$init])) {

                        // Find the link of what the code was on
                        $line = $this->getLine($file,$vars[0][$i]);

                        // Replaces caller to display error on information
                        $file = str_replace($vars[0][$i], $this->error("$init is not set in data array", $line), $file);
                        break;// Ends for loop execution
                    }
                    
                    $file = str_replace($vars[0][$i], $data[$init], $file);// Replaces file if valid data is preset
                }


            }
            
        }
        
        echo $file; // Echos file for valid output
        return;


    }

    private function getLine($file, $query) {

        $line = explode(PHP_EOL,$file); // Turns file into array
        $codeLine = 1; // Starts at one for initial basis
        
        for($i = 0; $i < count($line); $i++) {
            if (strpos($line[$i], $query) > -1) { // Checks if line of code exist on current file line
                $codeLine += $i; // Adds current iteration with Codeline to correct iteration offset
                break;
            }            
        }
        return $codeLine;
    }

    private function error($error, $line) {
        return '<br> <font size="1"> <table border="1" cellspacing="0" cellpading="1"> <tbody> <tr> <th align="left" bgcolor="#f57900" colspan="5"> <span style="background-color: #cc0000; color: #fce94f; font-size: x-large;">( ! )</span> ' . $error . ' on line <i>' . $line . '</i>&nbsp; </th> </tr> </tbody> </table> </font> <br>';
    }
}