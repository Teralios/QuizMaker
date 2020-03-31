<?php
namespace wcf\data\quiz\question;

use wcf\data\DatabaseObjectList;
use wcf\data\quiz\Quiz;

class QuestionList extends DatabaseObjectList
{
    /**
     * @var Quiz
     */
    protected $quiz = null;

    /**
     * QuestionList constructor.
     * @param Quiz|null $quiz
     * @throws \wcf\system\exception\SystemException
     */
    public function __construct(Quiz $quiz = null)
    {
        parent::__construct();

        if ($this->quiz !== null) {
            $this->quiz = $quiz;
            $this->defaultCommand();
        }
    }

    /**
     * Build standard condition.
     */
    protected function defaultCommand()
    {
        $this->getConditionBuilder()->add('quizID = ?', [$this->quiz->quizID]);

        // default order
        $this->sqlOrderBy = 'position ASC';
    }
}