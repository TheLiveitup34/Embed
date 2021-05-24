<?php
// Designed by RKStudio 
// Embed is a variable parser to allow easy embed to pull html files into html structure to not have to escape php
// 

class Embed {

    private $file = "";
    private $vars = "";
    public function __construct($file) {
        if (!file_exists($file)) {
            die("file at: $file does not exist!");
        }

        $file = file_get_contents($file); // reads file from url or local directory
        preg_match_all( '/{{(.*)}}/', $file, $vars, PREG_PATTERN_ORDER); // Checks for variable patterns of {{ VAR }}

        $this->file = $file;
        $this->vars = $vars;
    }

    public function callFile($data = []) {
     
      


        if (isset($this->vars[0]) && !empty($this->vars[0])) {
            
            for($i = 0; $i < count($this->vars[0]); $i++) {

                $init = (strpos($this->vars[1][$i], '.') > -1) ? explode('.',trim($this->vars[1][$i])) : trim($this->vars[1][$i]);
                
                if (is_array($init)) {

                    
                    if (!isset($data[$init[0]])) {
                        
                        // Find the link of what the code was on
                        $line = $this->getLine($file,$this->vars[0][$i]);

                        // Replaces caller to display error on information
                        $this->file = str_replace($this->vars[0][$i], $this->error("$init[0] is not set in data array", $line), $this->file);
                        break; // Ends for loop execution
                    }

                    if (!isset($data[$init[0]][$init[1]])) {

                        // Find the link of what the code was on
                        $line = $this->getLine($this->file,$this->vars[0][$i]);

                        // Replaces caller to display error on information
                        $this->file = str_replace($this->vars[0][$i], $this->error("Call to undefined key of $init[1] in array $init[0]", $line), $this->file);
                        break; // Ends for loop execution
                    }

                    $origin = $data[$init[0]][$init[1]];

                    if (count($init) >= 3) {

                        for($s = 2; $s < count($init); $s++) {

                            if (!isset($origin[$init[$s]])) {
                                
                                $line = $this->getLine($this->file,$this->vars[0][$i]);

                                $this->file = str_replace($this->vars[0][$i], $this->error("Call to undefined key of $init[$s]", $line), $this->file);
                                break;
                            }
                            
                            if (is_array($origin[$init[$s]])) {
                                $origin = $origin[$init[$s]];
                                continue;
                            }

                            $origin = $origin[$init[$s]];
                        }

                    }

                    if (is_array($origin)) {
                        $line = $this->getLine($this->file,$this->vars[0][$i]);
                        $origin = $this->error("Unexpected array " . json_encode($origin), $line);
                    }

                    $this->file = str_replace($this->vars[0][$i], $origin,$this->file); // Replaces this->file if valid data is preset
                

                } else {

                    if (!isset($data[$init])) {

                        // Find the link of what the code was on
                        $line = $this->getLine($this->file,$this->vars[0][$i]);

                        // Replaces caller to display error on information
                        $this->file = str_replace($this->vars[0][$i], $this->error("$init is not set in data array", $line), $this->file);
                        continue; // Ends current loop and goes to next iteration
                    }
                    
                    $this->file = str_replace($this->vars[0][$i], $data[$init], $this->file);// Replaces this->file if valid data is preset
                }


            }
            
        }
        
        echo $this->file; // Echos file for valid output
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