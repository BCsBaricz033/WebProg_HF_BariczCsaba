<?php

class Doctor
{
    private $ID;
    private $Name;
    private $SectionId;

    /**
     * @param $ID
     * @param $Name
     * @param $SectionId
     */
    public function __construct($ID, $Name, $SectionId)
    {
        $this->ID = $ID;
        $this->Name = $Name;
        $this->SectionId = $SectionId;
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
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @param mixed $Name
     */
    public function setName($Name)
    {
        $this->Name = $Name;
    }

    /**
     * @return mixed
     */
    public function getSectionId()
    {
        return $this->SectionId;
    }

    /**
     * @param mixed $SectionId
     */
    public function setSectionId($SectionId)
    {
        $this->SectionId = $SectionId;
    }



}