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
 * Language strings for Mad Libs block.
 *
 * @package    block_madlibs
 * @category   string
 * @copyright  2021 Danny Jung
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Plugin strings.
$string['pluginname'] = 'Mad Libs';
$string['madlibs'] = 'Mad Libs';

// Capability strings.
$string['madlibs:addinstance'] = 'Add a new Mad Libs block';
$string['madlibs:addsentences'] = 'Add sentences';
$string['madlibs:addwords'] = 'Add words';
$string['madlibs:myaddinstance'] = 'Add a new Mad Libs block to Dashboard';

// Form strings.
$string['addsentence'] = 'Add a new sentence';
$string['addword'] = 'Add a new word';
$string['category'] = 'Category';
$string['category_help'] = 'Category of word for placeholder replacement in sentences.';
$string['nosentences'] = 'No sentences have been added.';
$string['sentence'] = 'Sentence';
$string['sentence_help'] = 'Sentence should include categorized placeholders for words. Add placeholders by wrapping categories in a single set of square brackets.

Available categories for placeholders:<br/>
noun, verb, adjective, adverb';
$string['word'] = 'Word';
