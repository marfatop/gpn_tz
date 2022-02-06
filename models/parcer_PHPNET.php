<?php
//namespace PARCER/PHPNET;
include "lib/parcer.php";

class parcer_PHPNET extends parcer
{
    public $data;

    public function getData(string $url): object
    {
        $this->data = new stdClass();

        $this->data->contents=$this->getContentsXML($url);

        $this->data->counter=$this->countItems();
        $this->data->counteraveragewords=$this->countItemsWords();
        $this->data->titles=$this->getItemsTitle();
        return $this->data;
    }

    public function getContentsXML(string $url) : object
    {
        return simplexml_load_file($url);
    }

    public function countItems(): string
    {
        $counter=$this->data->contents->count();
        return $counter;
    }

    public function countItemsWords(): string
    {
        $nums = [];
        foreach ($this->data->contents->item as $index => $item) {
            $nums[] = str_word_count($item->description,0);
        }
        $res=ceil(array_sum($nums) / count($nums));

        return $res;
    }

    public function getItemsTitle(): array
    {
        $arr_titles=[];
        foreach ($this->data->contents->item as $index => $item) {
            $title=$item->title->__toString();
            $arr_titles[] = $title;
        }
        $temp=array_unique($arr_titles, SORT_STRING );
        var_dump($temp);
        return $arr_titles;
    }

    public function getAllCategories(): array
    {
        // TODO: Implement getAllCategories() method.
        return '';
    }

    public function getTopWords(): array
    {
        // TODO: Implement getTopItems() method.
        return '';
    }

    public function getNextItemTime(): string
    {
        // TODO: Implement getNextItemTime() method.
        return '';
    }

    public function countItemsLetters(): string
    {
        // TODO: Implement countItemsLetters() method.
        return '';
    }
}