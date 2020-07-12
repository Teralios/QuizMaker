<?php

namespace wcf\data\Quiz;

// imports
use wcf\data\DatabaseObjectEditor;
use wcf\system\database\exception\DatabaseQueryException;
use wcf\system\database\exception\DatabaseQueryExecutionException;
use wcf\system\file\upload\UploadFile;
use wcf\system\WCF;
use wcf\util\FileUtil;
use wcf\util\ImageUtil;

/**
 * Class QuizEditor
 *
 * @package   de.teralios.quizMaker
 * @author    Teralios
 * @copyright ©2019 Teralios.de
 * @license   GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 *
 * @method string getImage(bool $usePath)
 * @property-read int $quizID
 * @property-read int $languageID
 * @property-read string $title
 * @property-read string $description
 * @property-read string $type
 * @property-read string $image
 * @property-read int $creationDate
 * @property-read int $isActive
 * @property-read int $questions
 * @property-read int $goals
 */
class QuizEditor extends DatabaseObjectEditor
{
    protected static $baseClass = Quiz::class;

    /**
     * Increment counters for quiz.
     *
     * @param bool $questions
     */
    public function incrementCounter(bool $questions = true)
    {
        $data = [];

        if ($questions === true) {
            $data['questions'] = $this->questions + 1;
        } else {
            $data['goals'] = $this->goals + 1;
        }

        $this->update($data);
    }

    /**
     * Activate or deactivate a quiz.
     */
    public function toggle()
    {
        $this->update(['isActive' => ($this->isActive) ? 0 : 1]);
    }

    /**
     * Update counter for quiz after deletion of questions or stages.
     * @param int $quizID
     * @param int $counter
     * @param bool $questions
     * @throws DatabaseQueryException
     * @throws DatabaseQueryExecutionException
     */
    public static function updateCounterAfterDelete(int $quizID, int $counter, bool $questions = true)
    {
        $field = ($questions === true) ? 'questions' : 'goals';
        $sql = 'UPDATE  ' . static::getDatabaseTAbleNAme() . '
                SET     ' . $field . ' = ' . $field . ' - ?
                WHERE   quizID = ?';
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute([$counter, $quizID]);
    }
}
