<?php

namespace wcf\acp\page;

// imports
use wcf\data\quiz\ViewableQuizList;
use wcf\page\MultipleLinkPage;
use wcf\system\exception\SystemException;
use wcf\system\language\LanguageFactory;
use wcf\system\WCF;

/**
 * Class QuizListPage
 *
 * @package   de.teralios.quizMaker
 * @author    Teralios
 * @copyright ©2020 Teralios.de
 * @license   GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class QuizListPage extends MultipleLinkPage
{
    public $activeMenuItem = 'wcf.acp.menu.link.quizMaker.list';
    public $objectListClassName = ViewableQuizList::class;
    public $neededPermissions = ['admin.content.quizMaker.canManage'];

    public function initObjectList()
    {
        parent::initObjectList();

        /** @scrutinizer ignore-call */
        $this->objectList->loadMedia(false);
    }
    /**
     * @inheritDoc
     * @throws SystemException
     */
    public function assignVariables()
    {
        parent::assignVariables();

        /** @scrutinizer ignore-call */
        WCF::getTPL()->assign('isMultiLingual', LanguageFactory::getInstance()->multilingualismEnabled());
    }
}
