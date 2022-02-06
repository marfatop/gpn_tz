<?php


class parcer_INTERNETRU extends parcer
{
    public $data;
    private $date_formate;

    public function getData(string $url): object
    {
        $this->date_formate="Y-m-d H:i";
        $this->data = new stdClass();
        $this->data->contents = $this->getContentsXML($url);
        $this->data->counter = $this->countItems();
        $this->data->counteraveragewords = $this->countItemsWords();
        $this->data->titles = $this->getItemsTitle();
        $this->data->category = $this->getAllCategories();
        $this->data->topwords = $this->getTopWords();
        $this->data->lasttimeadd = $this->getLastItemTime();
        $this->data->nexttimeadd = $this->getNextItemTime();
        $this->data->letters=$this->countItemsLetters();
        return $this->data;
    }

    public function getContentsXML(string $url): object
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_FAILONERROR,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $retValue = curl_exec($ch);
        curl_close($ch);
        $oXML = new SimpleXMLElement($retValue);
        return $oXML;
    }

    public function countItems(): string
    {
        $counter = $this->data->contents->channel->item->count();
        return $counter;
    }

    public function countItemsWords(): string
    {
        $nums = [];
        foreach ($this->data->contents->channel->item as $index => $item) {
            $abc = 'АаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя0123456789%-';
            $str_tmp = $this->getClearString($item->description->__toString());
            $nums[] =str_word_count($str_tmp, 0, $abc);;
        }
        $res = ceil(array_sum($nums) / count($nums));
        return $res;
    }

    public function getItemsTitle(): array
    {
        $arr_titles = [];
        foreach ($this->data->contents->channel->item as $index => $item) {
            $title = $item->title->__toString();
            $arr_titles[] = $title;
        }
        return $arr_titles;
    }

    public function getAllCategories(): array
    {
        $arr_category = [];
        foreach ($this->data->contents->channel->item as $index => $item) {
            $category = $item->category->__toString();
            $arr_category[$category][] = $item;
        }
        return $arr_category;
    }

    public function getTopWords(): array
    {
        $words = [];
        foreach ($this->data->contents->channel->item as $index => $item) {
            $abc = 'АаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя0123456789%-';
            $str_tmp = $this->getClearString($item->description->__toString());
            $str_tmp = preg_replace("/[^a-zа-яD\s]/iu", "", $str_tmp);

            $arr_words = str_word_count($str_tmp, 1, $abc);

            $words = array_merge($words, $arr_words);
        }
        $arr_temp = array_count_values($words);
        arsort($arr_temp);
        $filtered = array_filter($arr_temp, function ($word_counter) {
            return $word_counter > 1;
        });
        return array_splice($filtered, 0, 10);
    }

    public function getNextItemTime(): string
    {

        $intervals = [];
        $average = '';

        $prevtime = '';
        foreach ($this->data->contents->channel->item as $index => $item) {
            $item_cur = $item;
            $currtime = new DateTime($item_cur->pubDate);

            $t = $currtime->getTimestamp();
            $arr[] = $t;

            if (empty($prevtime)) {
                $prevtime = $currtime;

            } else {
                $interval = $currtime->diff($prevtime);
                $intervals[] = $interval->h;
                $prevtime = $currtime;
            }
        }


        if (!empty($intervals)) {
            $average = ceil( array_sum($intervals) / count($intervals));
        }

        sort($arr);
        $d = new DateTime();
        $d->setTimestamp(end($arr));

        $d->modify(' + ' . $average . ' hours');

        return $d->format($this->date_formate);

    }

    public function getLastItemTime(): string
    {
        foreach ($this->data->contents->channel->item as $index => $item) {
            $d = new DateTime($item->pubDate->__toString());
            $t = $d->getTimestamp();
            $arr[] = $t;
        }
        sort($arr);

        $d = new DateTime();
        $d->setTimestamp(end($arr));
        $res = $d->format($this->date_formate);
        return $res;
    }


    public function countItemsLetters(): array
    {
        $abc=["а", "о", "э", "е", "и", "ы", "у", "ё", "ю", "я", 'a','e','i','o','u','y'];
        $arr=[];
        $str=[];
        $res=[];
        $item_counter=count($this->data->contents->channel->item);
        foreach ($this->data->contents->channel->item as $index => $item) {
            $str_tmp = $this->getClearString($item->description->__toString());
            $str_tmp=strtolower($str_tmp);
            $str_tmp=preg_replace("/[^a-zа-я]/iu", "", $str_tmp);

            foreach(mb_str_split($str_tmp) as $char)
            {
                if(in_array($char,$abc))
                {
                    $str['glasnye'][]=$char;
                }
                else{
                    $str['soglasnye'][]=$char;
                }
            }
        }
        $res=[
            'glasnye'=>ceil((count($str['glasnye'])/$item_counter)),
            'soglasnye'=>ceil ((count($str['soglasnye'])/$item_counter)),
        ];
        return $res;
    }

    function getClearString($str){
        $str = strip_tags($str);
        $str = htmlspecialchars($str);
        $str = trim($str);
        return $str;
    }
}