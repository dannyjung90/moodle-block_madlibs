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
 * Sentence class for Mad Libs block.
 *
 * @package    block_madlibs
 * @copyright  2021 Danny Jung
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_madlibs;

defined('MOODLE_INTERNAL') || die();

/**
 * Sentence class.
 *
 * @package    block_madlibs
 * @copyright  2021 Danny Jung
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class sentence {
    /** @var string Sentence text */
    public $sentence;

    /** @var int Timestamp for when this entry was created */
    public $timecreated;

    /** @var int Timestamp for when this entry was last modified */
    public $timemodified;

    /**
     * Constructor.
     *
     * @param string $sentence Sentence text (optional)
     */
    public function __construct($sentence = null) {
        $this->sentence = $sentence;
    }

    /**
     * Inserts this entry into the database.
     *
     * @return void
     */
    public function add() {
        global $DB;

        if (preg_match_all('/\[[^\]]*\]/', $this->sentence, $placeholders)) {
            for ($i = 0; $i < count($placeholders[0]); $i++) {
                $pos = strpos($this->sentence, $placeholders[0][$i]);
                $this->sentence = substr_replace($this->sentence, strtolower($placeholders[0][$i]), $pos,
                    strlen($placeholders[0][$i]));
            }
        }

        $this->timecreated = time();
        $this->timemodified = $this->timecreated;

        $DB->insert_record('block_madlibs_sentences', $this, false);
    }

    /**
     * Fills all placeholders in current sentence with random words from corresponding category.
     *
     * @return void
     */
    public function fill_placeholders() {
        if (preg_match_all('/\[([^\]]*)\]/', $this->sentence, $placeholders)) {
            for ($i = 0; $i < count($placeholders[1]); $i++) {
                if ($word = word::random($placeholders[1][$i])) {
                    $pos = strpos($this->sentence, $placeholders[0][$i]);
                    $this->sentence = substr_replace($this->sentence, '<u>' . $word . '</u>', $pos,
                        strlen($placeholders[0][$i]));
                }
            }
        }
    }

    /**
     * Fetches a random sentence from the database.
     *
     * @return boolean
     */
    public function random() {
        global $DB;

        if (!$sentencecount = $DB->count_records('block_madlibs_sentences')) {
            $this->sentence = '<i>' . get_string('nosentences', 'block_madlibs') . '</i>';
            return false;
        }

        $i = $sentencecount > 1 ? rand(1, $sentencecount) : 1;

        $random = $DB->get_records('block_madlibs_sentences', null, '', 'id, sentence', $i - 1, 1);
        $random = reset($random);

        $this->sentence = $random->sentence;

        return true;
    }
}
