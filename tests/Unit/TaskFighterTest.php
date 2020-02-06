<?php

namespace Tests\Unit;

use App\TaskFighter;
use Tests\TestCase;

class TaskFighterTest extends TestCase
{

    //Get older task variables
    const GET_OLDER = 'Get Older';
    const GET_OLDER_PRIORITY = 50;
    const GET_OLDER_DUE_IN = 365;
    const GET_OLDER_DUE_IN_EXPIRED = 0;

    //Spin the world variables
    const SPIN_THE_WORLD = 'Spin the World';
    const SPIN_THE_WORLD_PRIORITY = 1000;
    const SPIN_THE_WORLD_DUE_IN = 30;
    const SPIN_THE_WORLD_DUE_IN_EXPIRED = 0;

    //Complete assessment variables
    const COMPLETE_ASSESSMENT = 'Complete Assessment';
    const COMPLETE_ASSESSMENT_PRIORITY = 50;
    const COMPLETE_ASSESSMENT_DUE_IN = 15;
    const COMPLETE_ASSESSMENT_DUE_IN_EXPIRED = 9; //when due_in is less than 10 days priority doubles


    public function testPriorityNotNegative(){
         $getOlderTask = new TaskFighter(self::GET_OLDER, self::GET_OLDER_PRIORITY, self::GET_OLDER_DUE_IN);
         $getOlderPriority = $getOlderTask->getPriority();
         $this->assertGreaterThan(0, $getOlderPriority);

    }

    public function testGetOlderPriorityThresholdNotExceeded(){
        $getOlderTask = new TaskFighter(self::GET_OLDER, self::GET_OLDER_PRIORITY, self::GET_OLDER_DUE_IN);
        $getOlderPriority = $getOlderTask->getPriority();
        $this->assertLessThanOrEqual(100, $getOlderPriority);
    }

    public function testCompleteAssessmentPriorityThresholdNotExceeded(){
        $completeAssessment = new TaskFighter(self::COMPLETE_ASSESSMENT, self::COMPLETE_ASSESSMENT_PRIORITY, self::COMPLETE_ASSESSMENT_DUE_IN);
        $completeAssessmentPriority = $completeAssessment->getPriority();
        $this->assertLessThanOrEqual(100, $completeAssessmentPriority);
    }

    public function testAfterDueDateCompleteAssessmentPriorityDoubles(){
        // get original priority before due date expires
        $completeAssessment = new TaskFighter(self::COMPLETE_ASSESSMENT, self::COMPLETE_ASSESSMENT_PRIORITY, self::COMPLETE_ASSESSMENT_DUE_IN);
        $completeAssessmentPriority = $completeAssessment->getPriority();

        //test get older task with due date expired
        $completeAssessmentExpired = new TaskFighter(self::COMPLETE_ASSESSMENT, self::COMPLETE_ASSESSMENT_PRIORITY, self::COMPLETE_ASSESSMENT_DUE_IN_EXPIRED);
        $completeAssessmentPriorityExpiredDueDate = $completeAssessmentExpired->getPriority();

        $completeAssessmentPriorityExpected = 2 * $completeAssessmentPriority;
        $this->assertLessThanOrEqual($completeAssessmentPriorityExpected, $completeAssessmentPriorityExpiredDueDate);

    }



    public function testSpinTheWorldDoesNotIncreasePriority(){

        // spin the world with no due in days
        $spinTheWorldTaskExpired = new TaskFighter(self::SPIN_THE_WORLD, self::SPIN_THE_WORLD_PRIORITY, self::SPIN_THE_WORLD_DUE_IN_EXPIRED);
        $spinTheWorldTaskExpiredPriority = $spinTheWorldTaskExpired->getPriority();

        $this->assertEquals(1000, $spinTheWorldTaskExpiredPriority);

    }
}
