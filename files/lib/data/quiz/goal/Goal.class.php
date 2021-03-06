<?php

namespace wcf\data\quiz\goal;

// imports
use wcf\data\DatabaseOBject;
use wcf\system\database\exception\DatabaseQueryException;
use wcf\system\database\exception\DatabaseQueryExecutionException;
use wcf\system\WCF;

/**
 * Class goal
 *
 * @package   de.teralios.quizCreator
 * @author    Teralios
 * @copyright ©2020 Teralios.de
 * @license   GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 *
 * @property-read int $goalID
 * @property-read int $quizID
 * @property-read int $points
 * @property-read string $title
 * @property-read string $description
 * @property-read string $icon
 */
class Goal extends DatabaseObject
{
    // inherit variables
    protected static $databaseTableName = 'quiz_goal';
    protected static $databaseTableIndexName = 'goalID';

    /**
     * @param int $quizID
     * @param int $points
     * @return bool
     * @throws DatabaseQueryException|DatabaseQueryExecutionException
     */
    public static function checkGoalPoints(int $quizID, int $points): bool
    {
        $sql = 'SELECT  count(quizID) as goal
                FROM    ' . static::getDatabaseTableName() . '
                WHERE   quizID = ?
                        AND points = ?';
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute([$quizID, $points]);
        $row = $statement->fetchArray();

        return $row['goal'] > 0;
    }
}
