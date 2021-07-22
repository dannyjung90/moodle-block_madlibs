<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Edit form for Mad Libs block.
 *
 * @package    block_madlibs
 * @copyright  2021 Danny Jung
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');

class block_madlibs_edit_form extends moodleform {
    public function definition() {
        $mform =& $this->_form;

        $action = $this->_customdata['action'];

        $mform->addElement('header', 'general', get_string('general', 'form'));

        if ($action == 'addsentence') {
            $mform->addElement('textarea', 'sentence', get_string('sentence', 'block_madlibs'));
            $mform->setType('sentence', PARAM_TEXT);
            $mform->addRule('sentence', null, 'required', null, 'client');
        } else if ($action == 'addword') {
            $mform->addElement('text', 'word', get_string('word', 'block_madlibs'));
            $mform->setType('word', PARAM_TEXT);
            $mform->addRule('word', null, 'required', null, 'client');
            $mform->addRule('word', null, 'maxlength', 255, 'client');

            $options = array(
                null, "NOUN", "VERB", "ADJECTIVE", "ADVERB"
            );
            $mform->addElement('select', 'category', get_string('category', 'block_madlibs'), $options);
            $mform->addRule('category', null, 'required', null, 'client');
            $mform->setDefault('category', null);
        }

        $this->add_action_buttons(true, get_string('add'));

        $mform->addElement('hidden', 'action');
        $mform->setType('action', PARAM_ALPHA);
        $mform->setDefault('action', $action);
    }

    function validation($data, $files) {
        return array();
    }
}
