[![GitHub](https://img.shields.io/github/license/Teralios/QuizMaker?style=flat-square)](https://www.gnu.org/licenses/gpl-3.0.txt)[![GitHub release (latest by date including pre-releases)](https://img.shields.io/github/v/release/teralios/QuizMaker?include_prereleases&style=flat-square)](https://github.com/Teralios/QuizMaker/releases)[![Build Status](https://img.shields.io/travis/Teralios/QuizMaker.svg?style=flat-square)](https://travis-ci.org/Teralios/QuizMaker)[![Code Quality](https://img.shields.io/scrutinizer/g/Teralios/QuizMaker.svg?style=flat-square)](https://scrutinizer-ci.com/g/Teralios/QuizMaker/)
# Quiz Maker
Adds a simple quiz system to the [WoltLab® Suite Core(WSC)](https://www.woltlab.com/features/) that allows the team to create quizzes for members of one community.

There are two types of quizzes:
  * __Competition__ - where members compete against each other for the high score. The value of the correct answer drops from 10 points to 1 over time.
  * __Fun__ - Here it doesn't matter how long it takes, there is always 1 point, at the end you can present a funny evaluation via goals.

## Todo
### Beta 1
  - [x] Implement Quiz in frontend
  - [x] Implement base javascript for play

### Beta 2
  - [ ] Implement base javascript for play on QuizList
    - [x] Overwork Teralios/Quiz/Quiz to Teralios/QuizMaker/Game
    - [x] Implement Teralios/QuizMaker/Quiz for QuizPage
    - [ ] Implement Teralios/QuizMaker/QuizList for QuizListPage
    - [ ] Implement Teralios/Quiz/QuizBox for boxes
  - [ ] Implement result view for quiz
  - [x] Implement fun quiz support
  - [ ] Implement player list for quiz
  - [ ] Implement additional content on QuizList and Quiz
    - [ ] Last Player?
    - [ ] average score?

### Beta 3
  - [ ] Implement frontend editor for manage quiz
  - [ ] Implement more permissions
  - [ ] Implement "Quiz of the Day"-Box
  - [ ] Implement Quiz BBCode

### Beta 4
  - [ ] Implement Tags for quiz
  - [ ] Implement reaction
  - [x] Change image to media

### Beta 5
  - [ ] Implement trophies
  - [ ] ???
 
### RC1
  - [ ] Fix issues