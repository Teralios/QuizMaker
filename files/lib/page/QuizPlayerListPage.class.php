<?php

namespace wcf\page;

// imports
use wcf\data\quiz\game\GameList;
use wcf\system\WCF as WCF;

class QuizPlayerListPage extends MultipleLinkPage
{
    // quiz page trait
    use TQuizPage;

    // inherit vars
    public $objectListClassName = GameList::class;

    /**
     * @var GameList
     */
    public $objectList = null;


    public function readParameters()
    {
        parent::readParameters();

        $this->readQuizParameters();
        $this->setQuizParentLocation();
    }

    public function initObjectList()
    {
        parent::initObjectList();

        $this->objectList->withUser();
        $this->objectList->sqlOrderBy = $this->objectList->getDatabaseTableAlias() . '.score DESC';
        $this->objectList->sqlOrderBy .= ', ' . $this->objectList->getDatabaseTableAlias() . '.timeTotal ASC';
    }

    public function assignVariables()
    {
        parent::assignVariables();

        $this->assignQuizData();
        WCF::getTPL()->assign([
            'placementStart' => (1 + (25 * ($this->pageNo - 1)))
        ]);
    }
}