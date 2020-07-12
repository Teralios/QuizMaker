<?php

namespace wcf\data\Quiz;

// imports
use wcf\data\DatabaseObject;
use wcf\data\ILinkableObject;
use wcf\system\bbcode\SimpleMessageParser;
use wcf\system\Exception\SystemException;
use wcf\system\language\LanguageFactory;
use wcf\system\request\IRouteController;
use wcf\system\request\LinkHandler;

/**
 * Class QuizData
 *
 * @package   de.teralios.quizMaker
 * @author    Teralios
 * @copyright ©2019 Teralios.de
 * @license   GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 *
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
class Quiz extends DatabaseObject implements ILinkableObject, IRouteController
{
    // inherit vars
    protected static $databaseTableName = 'quiz';
    protected static $databaseTableIndexName = 'quizID';

    // const
    const COMPETITION = 'competition';
    const FUN = 'fun';

    /**
     * @inheritDoc
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Return description.
     *
     * @param bool $parsed
     * @return string
     * @throws SystemException
     */
    public function getDescription(bool $parsed = true): string
    {
        return ($parsed) ? SimpleMessageParser::getInstance()->parse($this->description) : $this->description;
    }

    /**
     * @inheritDoc
     * @throws SystemException
     */
    public function getLink()
    {
        return LinkHandler::getInstance()->getLink(
            'Quiz',
            [
                'object' => $this,
                'forceFrontend' => true
            ]
        );
    }

    /**
     * Returns language code.
     *
     * @return string
     * @throws SystemException
     */
    public function getLanguageIcon(): string
    {
        if (empty($this->languageID)) {
            return '';
        }

        return LanguageFactory::getInstance()->getLanguage($this->languageID)->getIconPath();
    }

    /**
     * Returns language name.
     *
     * @return string
     * @throws SystemException
     */
    public function getLanguageName(): string
    {
        return LanguageFactory::getInstance()->getLanguage($this->languageID)->languageName;
    }
}
