<?php
/**
 * User: sometimes
 * Date: 2016/10/8
 * Time: 15:00
 */

namespace common\component;



abstract class Lesson{
    protected $duration;

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }
    protected $constStrategy;

    function __construct($duration,Strategy $strategy)
    {
        $this->duration = $duration;
        $this->constStrategy=$strategy;
    }

    public function cost(){
        return $this->constStrategy->cost($this);
    }

    public function costType(){

    }
}

class Lecture extends Lesson{}
class Seminar extends Lesson{}




abstract class Strategy
{
    abstract public function cost(Lesson $lesson);
    abstract public function chargeType();
}

class TimedCostStrategy extends Strategy{
    public function cost(Lesson $lesson)
    {
        return $lesson->getDuration()*5;
    }

    public function chargeType()
    {
        return 'hourly rate';
    }

}

class FixedCostStrategy extends Strategy{
    public function cost(Lesson $lesson)
    {
        return 5;
    }

    public function chargeType()
    {
        return 'fixed rate';
    }

}

