<?php

namespace wcf\data\quiz\question;

// imports
use wcf\data\DatabaseObjectEditor;
use wcf\system\database\exception\DatabaseQueryException;
use wcf\system\exception\SystemException;
use wcf\system\WCF;

/**
 * Class QuestionEditor
 *
 * @package   de.teralios.quizCreator
 * @author    Teralios
 * @copyright ©2020 Teralios.de
 * @license   GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 *
 * @property-read int $questionID
 * @property-read int $quizID
 * @property-read int $position
 * @property-read string $question
 * @property-read string $optionA
 * @property-read string $optionB
 * @property-read string $optionC
 * @property-read string $optionD
 * @property-read string $answer
 */
class QuestionEditor extends DatabaseObjectEditor
{
    // inherit variables
    protected static $baseClass = Question::class;

    /**
     * @param array $parameters
     * @throws DatabaseQueryException
     */
    public function update(array $parameters = []): void
    {
        if ($this->position !== (int) $parameters['position']) {
            $this->updatePositions((int) $parameters['position']);
        }

        parent::update($parameters);
    }

    /**
     * @inheritDoc
     * @throws DatabaseQueryException
     */
    public static function create(array $parameters = []): Question
    {
        static::updatePositionsBeforeCreate($parameters['quizID'], $parameters['position'] ?? 1);

        return parent::create($parameters);
    }

    /**
     * Update positions.
     * @param int $quizID
     * @param int $position
     * @throws DatabaseQueryException
     */
    public static function updatePositionsBeforeCreate(int $quizID, int $position): void
    {
        $sql = 'UPDATE  ' . self::getDatabaseTableName() . '
                SET     position = position + 1
                WHERE   quizID   = ?
                    AND position >= ?';
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute([$quizID, $position]);
    }

    /**
     * Update positions after deletion.
     * @param int $quizID
     * @throws DatabaseQueryException
     * @throws SystemException
     */
    public static function updatePositionAfterDelete(int $quizID): void
    {
        $sql = 'SELECT      questionID, position
                FROM        ' . static::getDatabaseTableName() . '
                WHERE       quizID = ?
                ORDER BY    position';
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute([$quizID]);
        $questions = $statement->fetchObjects(Question::class);

        if (count($questions)) {
            $sql = 'UPDATE  ' . static::getDatabaseTableName() . '
                    SET     position = ?
                    WHERE   questionID = ?';
            $statement = WCF::getDB()->prepareStatement($sql);

            $newPosition = 1;
            foreach ($questions as $question) {
                /** @var Question $question */
                $statement->execute([$newPosition, $question->questionID]);
                ++$newPosition;
            }
        }
    }

    /**
     * Update positions of other questions.
     * @param int $newPosition
     * @throws DatabaseQueryException
     */
    protected function updatePositions(int $newPosition): void
    {
        if ($newPosition > $this->position) {
            $sql = 'UPDATE ' . static::getDatabaseTableName() . '
                    SET   position = position - 1
                    WHERE position BETWEEN ? AND ?
                        AND quizID = ?';
            $statement = WCF::getDB()->prepareStatement($sql);
            $statement->execute([$this->position, $newPosition, $this->quizID]);
        } else {
            $sql = 'UPDATE ' . static::getDatabaseTableName() . '
                    SET   position = position + 1
                    WHERE position BETWEEN ? AND ?
                        AND quizID = ?';
            $statement = WCF::getDB()->prepareStatement($sql);
            $statement->execute([$newPosition, $this->position, $this->quizID]);
        }
    }
}
