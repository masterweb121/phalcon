<?php
namespace Radio\Components;
use Phalcon\Mvc\User\Component;

class Menu extends Component
{
	public function __construct($controller, $action) {
        $this->controller = $controller;
        $this->action = $action;
    }
    public function getChannel(){
		$links = array(
				array('title'=>'Home', 'link'=>'/'),
				array('title'=>'Technology','link'=>'technology'),
				array('title'=>'Photography','link'=>'photography'),
				array('title'=>'Radio','link'=>'radio'),
				array('title'=>'About','link'=>'about')
		);
		return($links);
	}
    public function getMenu()
    {
		$menu = array(
            array('title'=>'频道首页', 'link'=>'radio/index'),
            array('title'=>'中继台', 'link'=>'radio/repeater'),
            array('title'=>'通联日志','link'=>'radio/logging'),
            array('title'=>'台网','link'=>'radio/net'),
            array('title'=>'信标','link'=>'radio/beacon'),
            array('title'=>'信令','link'=>'radio/signaling'),
            array('title'=>'产品','link'=>'radio/product'),
            array('title'=>'知识','link'=>'radio/knowledge'),
            array('title'=>'竞赛','link'=>'radio/contesting'),
            //array('title'=>'奖状','link'=>'radio/awards'),
            array('title'=>'软件','link'=>'radio/software'),
		);
		return( $menu );
    }
	public function getSubmenu($menu = null)
    {
		$submenu = array(
            'index' => array(
//                array('title'=>'Morse','link'=>'radio/morse'),
//                array('title'=>'Zone','link'=>'radio/zone'),
                array('title'=>'活动','link'=>'/outdoor/activity/category/radio/'),
                array('title'=>'无线电运动协会','link'=>'/radio/association'),
            ),
			'logging' => array(
                array('title'=>'FM','link'=>'/radio/logging/fm'),
                array('title'=>'AM','link'=>'/radio/logging/am'),
                array('title'=>'SSB','link'=>'/radio/logging/ssb'),
                array('title'=>'LSB','link'=>'/radio/logging/lsb'),
                array('title'=>'USB','link'=>'/radio/logging/usb'),
                array('title'=>'CW','link'=>'/radio/logging/cw'),

                array('title'=>'RTTY','link'=>'/radio/logging/rtty'),
                array('title'=>'SSTV','link'=>'/radio/logging/sstv'),
                array('title'=>'FSK','link'=>'/radio/logging/fsk'),
                array('title'=>'AFSK','link'=>'/radio/logging/afsk'),
                array('title'=>'PSK','link'=>'/radio/logging/psk'),

                array('title'=>'HF','link'=>'/radio/logging/hf'),
                array('title'=>'VHF','link'=>'/radio/logging/vhf'),
                array('title'=>'UHF','link'=>'/radio/logging/uhf'),
				array('title'=>'KUHF','link'=>'/radio/logging/kuhf'),
			),
            'repeater' => array(
                array('title'=>'Download','link'=>'/radio/repeater/download'),
                array('title'=>'Analog','link'=>'/radio/repeater/analog'),
                array('title'=>'Digital','link'=>'/radio/repeater/digital'),

                array('title'=>'UHF', 'link'=>'/radio/repeater/uhf'),
				array('title'=>'VHF','link'=>'/radio/repeater/vhf'),
                array('title'=>'DMR','link'=>'/radio/repeater/digital'),
                array('title'=>'C4FM','link'=>'/radio/repeater/digital'),
                array('title'=>'TDMA','link'=>'/radio/repeater/digital'),
                array('title'=>'FDMA','link'=>'/radio/repeater/digital')
			),
             'product' => array(
				array('title'=>'Yaesu', 'link'=>'/radio/product/yaesu'),
				array('title'=>'ICOM','link'=>'/radio/product/icom'),
				array('title'=>'Kenwood','link'=>'/radio/product/kenwood'),
                array('title'=>'Alinco','link'=>'/radio/product/alinco'),
                array('title'=>'Motorola','link'=>'/radio/product/motorola'),
                array('title'=>'Hytera','link'=>'/radio/product/hytera')
			),
            'knowledge' => array(
                array('title'=>'Morse','link'=>'/radio/knowledge/morse'),
                array('title'=>'Zone','link'=>'/radio/knowledge/zone'),
                array('title'=>'APRS','link'=>'/radio/knowledge/aprs'),
			),
            'net' => array(
                //array('title'=>'什么是台网','link'=>'/radio/knowledge/net'),
                //array('title'=>'Zone','link'=>'/radio/knowledge/zone'),
                //array('title'=>'APRS','link'=>'/radio/knowledge/aprs'),
			),
            'signaling' => array(
                array('title'=>'Mototrbo','link'=>'/radio/signaling/mototrbo'),
                array('title'=>'MDC1200','link'=>'/radio/signaling/mdc1200'),
                array('title'=>'Quik-Call II','link'=>'/radio/signaling/qcii'),
                array('title'=>'DTMF','link'=>'/radio/signaling/dtmf'),
                array('title'=>'Select V','link'=>'/radio/signaling/selectv'),
                array('title'=>'Yaesu(C4FM)','link'=>'/radio/signaling/c4fm'),
                array('title'=>'Download','link'=>'/radio/signaling/download'),
			),
            'beacon' => array(
                array('title'=>'Propagation','link'=>'/radio/beacon/propagation'),
			),
            'contesting' => array(
                array('title'=>'DXCC','link'=>'/radio/awards/dxcc'),
                array('title'=>'WAC','link'=>'/radio/awards/wac'),
                array('title'=>'WAS','link'=>'/radio/awards/was'),
			),
		);
		if(array_key_exists($this->controller,$submenu)){

			return($submenu[$this->controller]);
		}
		return( array());
    }
    public function getTabs()
    {
        //...
    }

}

