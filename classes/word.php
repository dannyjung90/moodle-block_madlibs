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
 * Word class for Mad Libs block.
 *
 * @package    block_madlibs
 * @copyright  2021 Danny Jung
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_madlibs;

defined('MOODLE_INTERNAL') || die();

/**
 * Word class.
 *
 * @package    block_madlibs
 * @copyright  2021 Danny Jung
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class word {
    /** @var string Word text */
    public $word;

    /** @var int Category ID */
    public $categoryid;

    /** @var int Timestamp for when this entry was created */
    public $timecreated;

    /** @var int Timestamp for when this entry was last modified */
    public $timemodified;

    /**
     * Constructor.
     *
     * @param string $word Word text
     * @param int $categoryid Category ID
     */
    public function __construct($word, $categoryid) {
        $this->word = $word;
        $this->categoryid = $categoryid;
    }

    /**
     * Inserts this entry into the database.
     *
     * @return void
     */
    public function add() {
        global $DB;

        $this->timecreated = time();
        $this->timemodified = $this->timecreated;

        $DB->insert_record('block_madlibs_words', $this, false);
    }

    /**
     * Fetches a random word of category from the database.
     *
     * @param string $category Category name (optional)
     * @return string|null
     */
    public static function random($category = null) {
        global $DB;

        if ($category) {
            $params = array('category' => $category);
            if (!$params = $DB->get_record('block_madlibs_categories', $params, 'id')) {
                return null;
            }
            $params = array('categoryid' => $params->id);
        }

        if (!$wordcount = $DB->count_records('block_madlibs_words', $params)) {
            return null;
        }

        $i = $wordcount > 1 ? rand(1, $wordcount) : 1;

        $random = $DB->get_records('block_madlibs_words', $params, '', 'id, word', $i - 1, 1);
        $random = reset($random);

        return $random->word;
    }
}
