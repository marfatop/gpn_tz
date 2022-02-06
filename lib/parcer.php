<?php
//namespace PARCER;

abstract class parcer
{
    /**
     * @var stdClass
     */
    //public $data;

    abstract public function getContentsXML(string $url) :object;

    abstract public function getData(string $url) : object;

    abstract public function countItems() : string;

    abstract public  function countItemsWords() : string;

    abstract public function getItemsTitle() : array;

    abstract public function getAllCategories() : array;

    abstract public function getTopWords() : array;

    abstract public function getNextItemTime() : string;
    abstract public function getLastItemTime() : string;

    abstract public function countItemsLetters() : array;
}