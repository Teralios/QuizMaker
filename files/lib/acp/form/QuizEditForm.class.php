<?php

namespace wcf\acp\form;

// imports
use wcf\data\quiz\goal\GoalList;
use wcf\data\quiz\question\QuestionList;
use wcf\data\quiz\Quiz;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\SystemException;
use wcf\system\WCF;

/**
 * Class QuizEditForm
 *
 * @package   de.teralios.quizCreator
 * @author    Teralios
 * @copyright ©2020 Teralios.de
 * @license   GNU General Public License <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class QuizEditForm extends QuizAddForm
{
    // inherit vars
    public $activeMenuItem = 'wcf.acp.menu.link.quizCreator.list';
    public $formAction = 'edit';

    /**
     * @var QuestionList
     */
    public $questionList;

    /**
     * @var GoalList
     */
    public $goalList;

    /**
     * @var bool
     */
    public $success = false;

    /**
     * @inheritDoc
     * @throws IllegalLinkException
     */
    public function readParameters()
    {
        parent::readParameters();

        // read quiz
        $id = $_REQUEST['id'] ?? 0;
        $this->formObject = new Quiz((int) $id);
        if (!$this->formObject->quizID) {
            throw new IllegalLinkException();
        }

        // success message
        $this->success = (isset($_REQUEST['success'])) ? filter_var($_REQUEST['success'], FILTER_VALIDATE_BOOLEAN) : false;
    }

    /**
     * @inheritDoc
     * @throws SystemException
     */
    public function readData()
    {
        parent::readData();

        // read questions
        $this->questionList = new QuestionList($this->formObject);
        $this->questionList->readObjects();

        // read goals
        $this->goalList = new GoalList($this->formObject);
        $this->goalList->readObjects();
    }

    /**
     * @inheritDoc
     */
    public function assignVariables()
    {
        parent::assignVariables();

        WCF::getTPL()->assign([
            'questionList' => $this->questionList,
            'goalList' => $this->goalList,
            'createSuccess' => $this->success
        ]);
    }
}
