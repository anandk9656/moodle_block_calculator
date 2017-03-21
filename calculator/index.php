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
 * Action page of the Calculator.
 *
 * @package    block_calculator
 * @copyright 2009 Dongsheng Cai <dongsheng@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/** Include this file for making this page as Moodle page.
 *  For using moodle session we need to do this.
 */
require_once("../../config.php");
global $DB, $USER;

// Code for calculator.
// 
// Check session variable value whether it is set or not.

if (!isset($_SESSION['input'])) { 
    
   // Works when any number except clear, backspace and answer is pressed.
    if (isset($_POST['num'])) {
        $_SESSION['input'] = $_POST['num'];
    }
} else {
    
    // If any number is pressed again, then it will concatenate the current 
    // number with the last session variable value (i.e. last enterd number).
    if (isset($_POST['num'])) {
        $_SESSION['input'] = $_SESSION['input'].$_POST['num'];
        
    // If answer button is pressed, evaluate the expression in session.
    } else if (isset ($_POST['Answer'])) {
            eval('$res= ' . $_SESSION['input'] . ';');
            
            // Store expression result in the session varible.
            $_SESSION['input'] = $res;
            
    // If backspace button is pressed, then substring the session variable by one.        
    } else if (isset ($_POST['Backspace'])) {
        
        // Substring the session variable while it is not empty.
        if (!empty($_SESSION['input'])) {
            $_SESSION['input'] = substr($_SESSION['input'], 0, -1);
        }
        
    // If clear button is pressed, then it will empty the session variable.    
    } else if (isset ($_POST['Clear'])) {
            $_SESSION['input'] = '';
    }
  
}

/** Code for inserting calculation data in the Database.
 *  This will works when any user pressed answer button of calculator.
 */
if (isset($_POST['Answer'])) {
    
    $data = new stdClass();
    
    // User Id of current logged in user.
    $data->userid = $USER->id;
    
    // Regular expression
    $data->expression = $_POST['input'];
    
    // Result of expression.
    $data->result = $res;
    
    // Inserting data in the table.
    $DB->insert_record('block_calculator_history', $data, false);
}

// Code for redirecting to the page where calculator is present.
$cid = $_POST['cid'];           // Getting course id.
$currenturl = $_POST['url'];    // Getting current page url for redirecting.

if ($currenturl == "/moodle/course/view.php") {
    
    // Code for redirecting to the course page.
    redirect(new moodle_url($CFG->wwwroot.'/course/view.php?id='.$cid.''));
} else {
    
    // Code for redirecting to the dashboard.
    redirect(new moodle_url($CFG->wwwroot.'/my/index.php'));
}