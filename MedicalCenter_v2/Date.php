<?php

class Date
{
    private $ID;
    private $Doctor;
    private $Patient;
    private $StartDate;
    private $EndDate;
    private $Reserved;
    private $Reason;
    private $CNP;
    private $BirthDate;
    private $Email;
    private $Phone;
    private $Section;
    private $doctorId;

    /**
     * @return mixed
     */
    public function getDoctorId()
    {
        return $this->doctorId;
    }

    /**
     * @param mixed $doctorId
     */
    public function setDoctorId($doctorId)
    {
        $this->doctorId = $doctorId;
    }

    /**

     * @param $Doctor
     * @param $Patient
     * @param $StartDate
     * @param $EndDate
     * @param $Reserved
     * @param $Reason
     * @param $CNP
     * @param $BirthDate
     * @param $Email
     * @param $Phone
     */
    public function __construct( $Doctor, $Patient, $StartDate, $EndDate, $Reserved, $Reason, $CNP, $BirthDate, $Email, $Phone)
    {

        $this->Doctor = $Doctor;
        $this->Patient = $Patient;
        $this->StartDate = $StartDate;
        $this->EndDate = $EndDate;
        $this->Reserved = $Reserved;
        $this->Reason = $Reason;
        $this->CNP = $CNP;
        $this->BirthDate = $BirthDate;
        $this->Email = $Email;
        $this->Phone = $Phone;
    }

    /**
     * @return mixed
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * @param mixed $ID
     */
    public function setID($ID)
    {
        $this->ID = $ID;
    }

    /**
     * @return mixed
     */
    public function getDoctor()
    {
        return $this->Doctor;
    }

    /**
     * @param mixed $Doctor
     */
    public function setDoctor($Doctor)
    {
        $this->Doctor = $Doctor;
    }

    /**
     * @return mixed
     */
    public function getPatient()
    {
        return $this->Patient;
    }

    /**
     * @param mixed $Patient
     */
    public function setPatient($Patient)
    {
        $this->Patient = $Patient;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->StartDate;
    }

    /**
     * @param mixed $StartDate
     */
    public function setStartDate($StartDate)
    {
        $this->StartDate = $StartDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->EndDate;
    }

    /**
     * @param mixed $EndDate
     */
    public function setEndDate($EndDate)
    {
        $this->EndDate = $EndDate;
    }

    /**
     * @return mixed
     */
    public function getReserved()
    {
        return $this->Reserved;
    }

    /**
     * @param mixed $Reserved
     */
    public function setReserved($Reserved)
    {
        $this->Reserved = $Reserved;
    }

    /**
     * @return mixed
     */
    public function getReason()
    {
        return $this->Reason;
    }

    /**
     * @param mixed $Reason
     */
    public function setReason($Reason)
    {
        $this->Reason = $Reason;
    }

    /**
     * @return mixed
     */
    public function getCNP()
    {
        return $this->CNP;
    }

    /**
     * @param mixed $CNP
     */
    public function setCNP($CNP)
    {
        $this->CNP = $CNP;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->BirthDate;
    }

    /**
     * @param mixed $BirthDate
     */
    public function setBirthDate($BirthDate)
    {
        $this->BirthDate = $BirthDate;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * @param mixed $Email
     */
    public function setEmail($Email)
    {
        $this->Email = $Email;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->Phone;
    }

    /**
     * @param mixed $Phone
     */
    public function setPhone($Phone)
    {
        $this->Phone = $Phone;
    }

    /**
     * @return mixed
     */
    public function getSection()
    {
        return $this->Section;
    }

    /**
     * @param mixed $Section
     */
    public function setSection($Section)
    {
        $this->Section = $Section;
    }


}