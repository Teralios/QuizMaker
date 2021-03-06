<?php

namespace wcf\data\quiz;

// imports
use wcf\data\DatabaseObjectList;

/**
 * Class QuizList
 *
 * @package   de.teralios.quizCreator
 * @author    Teralios
 * @copyright ©2020 Teralios.de
 * @license   GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class QuizList extends DatabaseObjectList
{
    // inherit variables
    public $className = Quiz::class;
}
