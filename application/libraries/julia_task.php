<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* ==============================================================
 *
 * Julia
 *
 * ==============================================================
 *
 * @copyright  2014 Richard Lobb, University of Canterbury
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('application/libraries/LanguageTask.php');

class Julia_Task extends Task {
    public function __construct($filename, $input, $params) {
        parent::__construct($filename, $input, $params);
        $this->default_params['memorylimit'] = 400; // Need more for numpy
        $this->default_params['interpreterargs'] = array('-BE');
    }

    public static function getVersionCommand() {
        return array('julia -v', '/Julia ([0-9._]*)/');
    }

    public function compile() {
        $cmd = "julia {$this->sourceFileName}";
        $this->executableFileName = $this->sourceFileName;
        list($output, $this->cmpinfo) = $this->run_in_sandbox($cmd);
        if (!empty($this->cmpinfo) && !empty($output)) {
            $this->cmpinfo = $output . '\n' . $this->cmpinfo;
        }
    }


    // A default name for Julia programs
    public function defaultFileName($sourcecode) {
        return 'prog.jl';
    }


    public function getExecutablePath() {
        return '/usr/bin/julia';
     }


     public function getTargetFile() {
         return $this->sourceFileName;
     }
};
