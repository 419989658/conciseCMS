<?php
/**
 * User: keven
 * Date: 2016/10/22
 * Time: 13:46
 */

class Person{
    private $name;
    private $age;
    private $sex;

    public static function create($name,$age,$sex)
    {
        $person = new self;
        $person->name = $name;
        $person->age = $age;
        $person->sex = $sex;
        return $person;
    }
}

$person = Person::create('sometimes','99','male');
echo get_class($person);

class Student extends Person{

}

$student = Student::create('sometimes1','100','male');
echo get_class($student);