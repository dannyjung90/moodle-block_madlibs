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
 * Mad Libs block.
 *
 * @package    block_madlibs
 * @copyright  2021 Danny Jung
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class block_madlibs extends block_base {
    public function init() {
        $this->title = get_string('madlibs', 'block_madlibs');
    }

    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();

        $madlib = new block_madlibs\sentence();
        $madlib->random();
        $madlib->fill_placeholders();
        $this->content->text = $madlib->sentence;

        $this->content->footer = '';
        if (has_capability('block/madlibs:addsentences', $this->context)) {
            $this->content->footer .= html_writer::link(new moodle_url('/blocks/madlibs/edit.php', ['action' => 'addsentence']),
                get_string('addsentence', 'block_madlibs')) . '<br/>';
        }
        if (has_capability('block/madlibs:addwords', $this->context)) {
            $this->content->footer .= html_writer::link(new moodle_url('/blocks/madlibs/edit.php', ['action' => 'addword']),
                get_string('addword', 'block_madlibs'));
        }

        return $this->content;
    }

    public function applicable_formats() {
        return array(
            'my' => true
        );
    }
}
