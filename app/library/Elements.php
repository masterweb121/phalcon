<?php

use Phalcon\Mvc\User\Component;

class Elements extends Component
{
	public function getChannel(){
		$links = array('<a class="" href="/">Home</a> ','<a class="" href="/">Blog</a> ','<a class="" href="/">News</a> ');
		//foreach ($links as $l){
			//yield $l;
			//echo $link;
		//}
		
		return($links);
	}
    public function getMenu()
    {
        //...
	return('
		<a class="brand" href="/">Home</a> | <a class="brand" href="#">About</a>
		');
    }
	public function getMenuitem()
    {
        //...
	return('
		<a class="brand" href="/">Home</a> | <a class="brand" href="#">About</a>
		');
    }
    public function getTabs()
    {
        //...
    }

}
