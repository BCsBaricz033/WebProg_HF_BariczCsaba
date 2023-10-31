<?php

include "Student.php";
include "Subject.php";
include "University.php";

$stud1=new Student("Baricz Csaba","xbcs");
$stud2=new Student("Nagy Károly","xnk");
$subj1=new Subject("op","Operacio");
$subj2=new Subject("web","Web Programozás");
$university1=new University();
$university1->addSubject($subj1->getCode(),$subj1->getName());
$university1->addSubject($subj2->getCode(),$subj2->getName());
echo "Egyetem kiiratása tárgyak hozzáadása után.<br>";
$university1->print();

$university1->addStudentOnSubject($subj1->getCode(),$stud1);
$university1->addStudentOnSubject($subj1->getCode(),$stud2);
$university1->addStudentOnSubject($subj2->getCode(),$stud1);
echo "Egyetem kiiratása tárgyak és tanulók hozzáadása után.<br>";
$university1->print();
//print_r($university1->getStudentsForSubject($subj1->getCode()));
//$university1->addStudentOnSubject($subj1->getCode(),$stud1); -- student exist hibakód
//$university1->print();

$university1->deleteStudentOnSubject($subj1->getCode(),$stud2);
$university1->print();
echo "Tantárgy törlése<br>";
$university1->deleteSubject($subj2);
$university1->addSubject("mt","matematika");
$university1->deleteSubject(new Subject("mt","matematika"));
$students= array($stud1,$stud2);

$stud1->setGrade($subj1,10);
$stud1->setGrade($subj2,9);

$stud2->setGrade($subj2,10);
$stud2->setGrade($subj1,3);
echo "Hallgatók jegyének kiiratása<br>";
$stud1->printGrades();
$stud2->printGrades();
echo "Hallgatók átlagának kiiratása<br>";
echo $stud1->getName()."-".$stud1->avgGrade();
echo $stud2->getName()."-".$stud2->avgGrade();
function sortStudents($students){
    usort($students, function ($a, $b) {


        return $a->avgGrade() <=> $b->avgGrade(); // Növekvő sorrend
    });
    foreach ($students as $student){
        echo $student->getName()."-".$student->avgGrade();
    }
}
echo "Lista rendezés kiiratása<br>";

sortStudents($students);