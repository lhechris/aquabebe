<?php

require('PicoFeed/Reader.php');

use PicoFeed\Reader;

class afeed {
    
	public $url;
	public $date;
	public $content;
	
    function __construct($date,$url,$texte) {
        $this->date=$date;
        $this->url=$url;
        $this->content=$texte;
    }
}

class ABFeed {

    public function ABFeed() {
        $this->url = 'https://www.facebook.com/feeds/page.php?format=rss20&id=525712244164403';
    }

    public function parser_picofeed() {

        $reader = new Reader;
        $ret='';

        // Try to discover the XML feed automatically
        $url = 'https://www.facebook.com/feeds/page.php?format=rss20&id=525712244164403';
        $reader->download($url);

        $parser = $reader->getParser();

        if ($parser !== false) {
            setlocale (LC_TIME, 'fr_FR','fra');
            $feed = $parser->execute();
            $ret = array();
	    setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
            foreach( $feed->items as $item) {
                array_push($ret,
                           new afeed(strftime("%A, %d %B %Y %H:%M",$item->updated),
                           $item->url,
                           $item->content));
            }
        } else {
           return "<p>Error while reading news</p>";
        }

        return $ret;
    }
}
