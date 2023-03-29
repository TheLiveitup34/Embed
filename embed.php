<?php
// Designed by RKStudio 
// Embed is a variable parser to allow easy embed to pull html files into html structure to not have to escape php
// 

class Embed {

    private $file = "";
    private $vars = [];
    private $blocks = [];
    public function __construct($file) {
        if (!file_exists($file)) {
            echo "File does not exist";
            return false;
       
        }

        $file = file_get_contents($file); // reads file from url or local directory
        $lines = explode(PHP_EOL, $file);
        
        // Require files and remove comments
        foreach($lines as $line) {
            // checks for comments of {# COMMENT #}
            if (preg_match('/{#(.*)#}/', $line, $comments)) {
                $file = str_replace($comments[0],"", $file);
            }

            // checks for block patterns of {& FILE &}
           if (preg_match('/{&(.*)&}/', $line, $includes)) {
                $includes[1] = str_replace(" ","",$includes[1]);

                if (!file_exists($includes[1])) {
                    echo "File does not exist: " . $includes[1] . PHP_EOL;
                    return false;
                }

                $file = str_replace($includes[0],file_get_contents($includes[1]), $file);
            }

        }
        // get updated File and lines
        $lines = explode(PHP_EOL, $file);

        $current_block = [];
        $block_identified = false;
        $block_name = "";
        // Get Varialbes and store them in an array
        foreach($lines as $key => $line) {
            if ($block_identified == true) {
                // echo $line . PHP_EOL;
                if (preg_match('/{%(.*)%}/', $line, $block)) {
                    if ("end$block_name" == strtolower(ltrim(rtrim($block[1])))) {

                        $block_identified = false;
                        $current_block['replace'] .= $line . PHP_EOL;
                        $current_block['content'] = rtrim(ltrim($current_block['content']));
                        array_push($this->blocks, $current_block);
                        $current_block = [];
                    } else {
                        $current_block['replace'] .= $line . PHP_EOL;
                        $current_block['content'] .= $line . PHP_EOL;
                    }
                    continue;
                } else {
                    $current_block['replace'] .= $line . PHP_EOL;
                    $current_block['content'] .= $line . PHP_EOL;
                    continue;
                }
                

            }

            // checks for block patterns of {% BLOCK %}
            if (preg_match('/{%(.*)%}/', $line, $block)) {
                $block_identified = true;
                $block_name = strtolower(rtrim(ltrim($block[1])));
                $block_details = explode(" ", $block_name);

                // Sets the block name to the function to be called
                $block_name = $block_details[0];
                
                unset($block_details[0]);
                $block_details = array_values($block_details);
                $block_details = implode(" ", $block_details);
        
                $block = [
                    'type' => $block_name,
                    'replace' => $line . PHP_EOL,
                    'args' => $block_details,
                    'content' => ""
                ];
                $current_block = $block;
                continue;
            }
            // checks for variable patterns of {{ VAR }}
            if (preg_match('/{{(.*)}}/', $line, $vars) && $block_identified == false) {
                $key = rtrim(ltrim($vars[1]));
                $var = [
                    'key' => $vars[0],
                    'var' => $key,
                    'parent' => $key
                ];
                if (strpos($key, '.') > -1) {

                    $var['order'] = explode('.', $key);
                    $var['parent'] = $var['order'][0];
                }

                array_push($this->vars, $var);
            }
        }

        // removes all whitespace from the beginning of the file
        $file = ltrim($file);
        // removes all whitespace from the end of the file
        $file = rtrim($file);
        // echo $file;
        $this->file = $file;
        return true;
    }

    public function callFile($data = []) {
     
        // replace variables with the data
        foreach($this->vars as $var) {
            if (isset($var['order'])) {
                $parent = $var['parent'];
                $order = $var['order'];
                unset($order[0]);
                $order = array_values($order);
                $value = $data[$parent];
                foreach($order as $key) {
                    $value = $value[$key];
                }
                $this->file = str_replace($var['key'], $value, $this->file);
            } else {
                $this->file = str_replace($var['key'], $data[$var['var']], $this->file);
            }
        }

        // replace blocks with the data
        foreach($this->blocks as $block) {
            switch($block['type']) {
                case 'if':
                    // get predefined variables
                    $defined = ["true", "false", 0, 1, "0", "1", "null", "==", "!=", ">", "<", ">=", "<=", "&&", "||", "!", "<=>", "and", "or", "xor"];
                    $args = explode(" ", $block['args']);
                    $vars = [];
                    $else = "";
                    foreach($args as $arg) {
                        if (!in_array($arg, $defined)) {
                            array_push($vars, $arg);
                        }
                    }
                    foreach($vars as $var) {
                        $data[$var] = ($data[$var]) ? "true" : "false";
                        $block['args'] = str_replace($var, $data[$var], $block['args']);
                    }

     
                    // check if the block has else statement
                    if (preg_match('/{%(.*)else(.*)%}/', $block['content'], $elses)) {
                        $else = explode($elses[0], $block['content']);
                        $block['content'] = $else[0];
                        $else = $else[1];
                    } else {
                        $else = "";
                    }


                    // check if the block should be replaced
                    if (eval("return $block[args];")) {
                        $this->file = str_replace($block['replace'], $block['content'], $this->file);
                    } else {
                        $this->file = str_replace($block['replace'], $else, $this->file);
                    }
                    break;
                case "foreach":

                    $args = explode(" ", $block['args']);
                    $vars = [];
                    $else = "";
                    $loop = $data[$args[0]];
                    $replace = "";
                    preg_match_all('/{{(.*)}}/', $block['content'], $keys);
                    foreach($loop as $value) {
                        $content = $block['content'];
                        for($i = 0; $i < count($keys[1]); $i++) {
                            $content = str_replace($keys[0][$i], $value[str_replace(' ', '', $keys[1][$i])], $content);
                        }
                        $replace .= $content;
                    }
                    $this->file = str_replace($block['replace'], $replace, $this->file);

                    break;
            }
        }

        echo $this->file;
    }
}