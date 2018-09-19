<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lotto extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Reward_model');
    }

	public function index()
	{        
        $lottos = $this->Reward_model->get_all();
		$this->load->view('lotto/index', array('lottos' => $lottos));
    }
    
    public function random()
    {        
        $this->Reward_model->delete_all();

        $no1 = $this->number(3);
        $lot1 = array('code' => 'lot1', 'rank' => 1, 'lotto' => $no1, 'type' => 'รางวัลที่ 1');
        $this->Reward_model->store($lot1);

        foreach(range(0, 2) as $item){
            $this->Reward_model->store(
                array('code' => 'lot2_'.$item, 'rank' => ($item+1), 'lotto' => $this->number(3), 'type' => 'รางวัลที่ 2')
            );
        }

        $this->Reward_model->store(array('code' => 'lot_near_1', 'rank' => 1, 'lotto' => str_pad(($no1-1), 3, '0', STR_PAD_LEFT), 'type' => 'รางวัลเลขข้างเคียงรางวัลที่ 1'));
        $this->Reward_model->store(array('code' => 'lot_near_2', 'rank' => 2, 'lotto' => str_pad(($no1+1), 3, '0', STR_PAD_LEFT), 'type' => 'รางวัลเลขข้างเคียงรางวัลที่ 1'));
        $this->Reward_model->store(array('code' => 'lot_que', 'rank' => 1, 'lotto' => $this->number(2), 'type' => 'รางวัลเลขท้าย 2 ตัว'));
        redirect(base_url(), 'refresh');
    }

    private function number($digit)
    {
        $max = $digit===3 ? 999 : 99;
        return str_pad(rand(0, $max), $digit, '0', STR_PAD_LEFT);
    }

    public function search()
    {
        $result = $this->Reward_model->get_by_lotto($this->input->get('lotto'));                
        exit(json_encode($result));
    }
}
