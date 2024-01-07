<?php

class User
{
    private $ID;
    private $UserName;
    private $name;
    private $Email;
    private $Phone;
    private $Adress;
    private $Type;
    private $SectionID;

    /**
     * @param $ID
     * @param $UserName
     * @param $name
     * @param $Email
     * @param $Phone
     * @param $Adress
     * @param $Type
     * @param $SectionID
     */
    public function __construct($ID, $UserName, $name, $Email, $Phone, $Adress, $Type, $SectionID)
    {
        $this->ID = $ID;
        $this->UserName = $UserName;
        $this->name = $name;
        $this->Email = $Email;
        $this->Phone = $Phone;
        $this->Adress = $Adress;
        $this->Type = $Type;
        $this->SectionID = $SectionID;
    }


    /**
     * @return mixed
     */
    public function getSectionID()
    {
        return $this->SectionID;
    }

    /**
     * @param mixed $SectionID
     */
    public function setSectionID($SectionID)
    {
        $this->SectionID = $SectionID;
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
    public function getUserName()
    {
        return $this->UserName;
    }

    /**
     * @param mixed $UserName
     */
    public function setUserName($UserName)
    {
        $this->UserName = $UserName;
    }

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
    public function setName($name)
    {
        $this->name = $name;
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
    public function getAdress()
    {
        return $this->Adress;
    }

    /**
     * @param mixed $Adress
     */
    public function setAdress($Adress)
    {
        $this->Adress = $Adress;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->Type;
    }

    /**
     * @param mixed $Type
     */
    public function setType($Type)
    {
        $this->Type = $Type;
    }

}