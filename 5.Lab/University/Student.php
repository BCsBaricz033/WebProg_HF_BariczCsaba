<?php
/**
 * User: TheCodeholic
 * Date: 4/8/2020
 * Time: 10:40 PM
 */

/**
 * Class Student
 */
class Student
{
    private string $name;
    private string $studentNumber;
    private array $grades = [] ;




    /**
     * @param string $name
     * @param string $studentNumber
     */
    public function __construct(string $name, string $studentNumber,array $grades=[])
    {
        $this->name = $name;
        $this->studentNumber = $studentNumber;
        $this->grades=$grades;

    }

    public function getGrades(): array
    {
        return $this->grades;
    }

    public function setGrades(array $grades): void
    {
        $this->grades = $grades;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getStudentNumber(): string
    {
        return $this->studentNumber;
    }

    public function setStudentNumber(string $studentNumber): void
    {
        $this->studentNumber = $studentNumber;
    }

    public function __toString()
    {
        return $this->getName()."-".$this->getStudentNumber();
    }
    public function setGrade(Subject $subject,int $note){
        $this->grades[$subject->getCode()] = $note;
    }
    public function avgGrade(){
        $sum=0;
        foreach ($this->grades as $code=>$grade){
            $sum+=$grade;
        }
        return $sum/count($this->grades)."<br>";
    }
    public function printGrades(){
        foreach ($this->grades as $code=>$grade){
            echo $this->getName().": ".$code."-".$grade."<br>";
        }
    }


}
