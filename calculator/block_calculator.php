<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * calculator block.
 *
 * @package    block_calculator
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class block_calculator extends block_base {
    
    /**
     * Core function used to initialize the block.
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_calculator');
    }
    
    /**
     * Used to generate the content for the block.
     * @return string
     */
    public function get_content() {
        global $CFG;
        $input = '';
        
        if ($this->content !== null) {
            return $this->content;
        }
        
        $cid  = optional_param('id', '', PARAM_INT); // Gives the Course Id.
        
        if (isset($_SESSION['input'])) {
            
            // Getting session value from action page of the form.
            $input = $_SESSION['input']; 
        }

        $this->content = new stdClass();
        $this->content->text = '';
        
        // Code for displaying calculator in the body of block.
        
        /**
         * @value $cid :- Pass course id.
         * @value $_SERVER['PHP_SELF'] :- Pass current page URL.
         * @value $input :- Get value for displaying in the input field of calculator.
         */
        $this->content->text .= '<div align = "center">
                            <form action='.$CFG->wwwroot."/blocks/calculator/index.php".' method="POST">
                            <input type="hidden" name="url" value="'.htmlspecialchars($_SERVER['PHP_SELF']).'">
                            <input type="hidden" name="cid" value="'.$cid.'">
                            <input type="text" name="input" value="'.$input.'">
                            <br>
                            <input type="submit" name="Backspace" value="Bk"/>
                            <input type="submit" name="Clear" value="Clr"/>
                            <br>
                            <input type="submit" name="num" value="1" />
                            <input type="submit" name="num" value="2" />
                            <input type="submit" name="num" value="3" />
                            <input type="submit" name="num" value="+" />
                            <br/> <br/>
                            <input type="submit" name="num" value="4" />
                            <input type="submit" name="num" value="5" />
                            <input type="submit" name="num" value="6" />
                            <input type="submit" name="num" value="-" />
                            <br/> <br/>
                            <input type="submit" name="num" value="7" />
                            <input type="submit" name="num" value="8" />
                            <input type="submit" name="num" value="9" />
                            <input type="submit" name="num" value="*" />
                            <br/> <br/>
                            <input type="submit" name="num" value="." />
                            <input type="submit" name="num" value="0" />
                            <input type="submit" name="Answer" value="="/>
                            <input type="submit" name="num" value="/" />
                            </form> </div>';
        return $this->content;
    }
    
    /**
     * Allows the block to be added multiple times to a single page
     * @return boolean
     */
    public function instance_allow_multiple() {
        return true;
    }
    
    /**
     * Core function, specifies where the block can be used.
     * @return array
     */
    public function applicable_formats() {
        return array('all' => true,
                     'site' => false
                    );
    }
    
}