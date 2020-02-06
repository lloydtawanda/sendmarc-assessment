<?php
namespace App;

class TaskFighter
{

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param mixed $priority
     */
    public function setPriority($priority): void
    {
        $this->priority = $priority;
    }

    /**
     * @return mixed
     */
    public function getDueIn()
    {
        return $this->dueIn;
    }

    /**
     * @param mixed $dueIn
     */
    public function setDueIn($dueIn): void
    {
        $this->dueIn = $dueIn;
    }

    private $name;
    private $priority;
    private $dueIn;

    const GET_OLDER = 'Get Older';
    const SPIN_THE_WORLD = 'Spin the World';
    const COMPLETE_ASSESSMENT = 'Complete Assessment';

    public function __construct($name, $priority, $due_in)
    {
        $this->name = $name;
        $this->priority = $priority;
        $this->dueIn = $due_in;
    }

    public static function of($name, $priority, $dueIn) {
        return new static($name, $priority, $dueIn);
    }

    private function tickCompleteAssessment(){
        if ($this->priority < 100) {
            $this->priority = $this->priority + 1;

            if($this->dueIn < 11){
                $this->priority = $this->priority + 1;
            }

            if($this->dueIn < 6){
                $this->priority = $this->priority + 1;
            }

        }

        $this->dueIn = $this->dueIn - 1;

        if ($this->dueIn < 0){
            $this->priority = 0;
        }
    }

    private function tickGetOlder(){
        if ($this->priority > 0) {
            $this->priority = $this->priority - 1;
        }

        $this->dueIn = $this->dueIn - 1;

        if ($this->dueIn < 0 and $this->priority > 0){
            $this->priority = $this->priority - 1;
        }
    }

    private function tickSpinTheWorld(){
        $this->priority = $this->priority;
    }

    public function tick()
    {
       switch ($this->name){
           case self::GET_OLDER:
               $this->tickGetOlder();
               break;
           case self::COMPLETE_ASSESSMENT:
               $this->tickCompleteAssessment();
               break;
           default:
               $this->tickSpinTheWorld();
               break;
       }
    }
}

