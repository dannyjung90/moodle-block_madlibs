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
 * Edit page for Mad Libs block.
 *
 * @package    block_madlibs
 * @copyright  2021 Danny Jung
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/blocks/madlibs/edit_form.php');

$action = required_param('action', PARAM_ALPHA);

// Page setup.
$PAGE->set_url('/blocks/madlibs/edit.php', array('action' => $action));

require_login();

$context = context_system::instance();
$PAGE->set_context($context);

$PAGE->navbar->add(get_string('madlibs', 'block_madlibs'));
$pagetitle = get_string('madlibs', 'block_madlibs');

if ($action == 'addsentence') {
    $PAGE->navbar->add(get_string('addsentence', 'block_madlibs'),
        new moodle_url('/blocks/madlibs/edit.php', ['action' => 'addsentence']));
    $pagetitle .= ': ' . get_string('addsentence', 'block_madlibs');
    require_capability('block/madlibs:addsentences', $context);
} else if ($action == 'addword') {
    $PAGE->navbar->add(get_string('addword', 'block_madlibs'),
        new moodle_url('/blocks/madlibs/edit.php', ['action' => 'addword']));
    $pagetitle .= ': ' . get_string('addword', 'block_madlibs');
    require_capability('block/madlibs:addwords', $context);
}

$PAGE->set_title("$SITE->shortname: " . $pagetitle);
$PAGE->set_heading($SITE->fullname);

// Form setup.
$mform = new block_madlibs_edit_form(null, array('action' => $action));

if ($mform->is_cancelled()) {
    redirect(new moodle_url('/my/'));
} else if ($formdata = $mform->get_data()) {
    switch ($action) {
        case 'addsentence':
            $sentence = new block_madlibs\sentence($formdata->sentence);
            $sentence->add();
        break;

        case 'addword':
            $word = new block_madlibs\word($formdata->word, $formdata->category);
            $word->add();
        break;

        default :
            throw new moodle_exception('invalidaction');
    }

    redirect(new moodle_url('/my/'));
}

if ($action != 'addsentence' && $action != 'addword') {
    throw new moodle_exception('unknowaction');
}

// Output.
echo $OUTPUT->header();
echo $OUTPUT->heading($pagetitle);

$mform->display();

echo $OUTPUT->footer();
