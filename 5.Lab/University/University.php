<?php

class University extends AbstractUniversity
{


    public function __construct()
    {

    }

    public function addSubject(string $code, string $name): Subject
    {
        $subject=new Subject($code,$name);
        if($this->isSubjectExists($subject)){
            throw new Exception("Subject exists");
        }
        else{
            array_push($this->subjects,$subject);
            echo $name." Has been added succesfully<br>";
            return $subject;
        }
    }
    public function isSubjectExists(Subject $subject): bool
    {
        if(in_array($subject,$this->subjects)){
            return true;
        }
        else{
            return false;
        }
    }

    public function addStudentOnSubject(string $subjectCode, Student $student)
    {
        foreach ($this->subjects as $subject) {
            if ($subject->getCode() == $subjectCode) {
                $subject->addStudent($student->getName(),$student->getStudentNumber());
                break;
            }

        }
    }
    public function deleteStudentOnSubject(string $subjectCode, Student $student)
    {
        foreach ($this->subjects as $subject) {
            if ($subject->getCode() == $subjectCode) {
                $subject->deleteStudent($student);
                break;
            }

        }
    }


    public function getStudentsForSubject(string $subjectCode)
    {
        foreach ($this->subjects as $subject) {
            if ($subject->getCode() == $subjectCode) {
                return $subject->getStudents();

            }
        }
    }

    public function getNumberOfStudents(): int
    {
        $numberStudents=0;

        foreach ($this->subjects as $subject) {

            foreach ($subject->getStudents() as $student){
                $numberStudents++;
            }
        }
        return $numberStudents;
    }


    public function print()
    {
        foreach ($this->subjects as $subject) {
            echo "---------------------------------<br>";
            echo $subject->getName()."<br>";
            echo "---------------------------------<br>";
            foreach ($subject->getStudents() as $student){
                echo $student."<br>";
            }
        }
    }
    public function deleteSubject(Subject $subject){
        try {
            if(count($this->getStudentsForSubject($subject->getCode()))==0){
                for ($x = 0; $x <= count($this->subjects); $x++) {
                    if($this->subjects[$x]->getCode()==$subject->getCode()){
                        unset($this->subjects[$x]);
                        echo $subject->getName()." has been deleted!<br>";
                        break;
                    }
                }
            }else{
                throw new HasStudent("The subject has students!");
            }
        }catch ( HasStudent $err){
            echo  $err->getMessage()."<br>";
        }

    }
}
