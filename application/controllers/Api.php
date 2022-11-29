<?php

class Api extends CI_Controller
{
    public function __construct($user_id = null)
    {
        parent::__construct();
        $this->yield    = false;
        $this->load->model('M_api', 'm_api');
        header('Content-Type: application/json');
    }


    //토론 카테고리
    function getDebateCategory(){

        $data = $this->m_api->selectDebateCategory();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    //컨텐츠
    function getContentsList(){

    }


    function getContentsOne(){

        $idx  = $this->input->post('idx');
        $data = $this->m_api->selectContentsOne($idx);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }


    function getDebateRoomList(){

        $this->data['page']         = $this->input->get_post('page') ?? 1;
        $this->data['size']         = $this->input->get_post('size') ?? 3;

        $this->data['category']     = $this->input->get_post('category') ?? '';

        $this->data['cur_page']     = $this->data['page'];
        $this->data['tot_row']      = $this->m_api->selectDebateRoomCount($this->data['category']);
        $this->data['tot_page']     = ceil($this->data['tot_row'] / $this->data['size']);
        $this->data['cur_num']      = $this->data['tot_row'] - $this->data['size'] * ($this->data['cur_page'] - 1);
        $this->data["result"]       = $this->m_api->selectDebateRoomList($this->data['category']);

        foreach ($this->data["result"] as $key => $rows){
            $hash_tag         = '';
            $connect_cnt      = 0;

            $hash_tag_data    = $this->m_api->selectDebateRoomHashtag($rows['idx']);
            $connect_cnt      = $this->m_api->selectDebateRoomConnect($rows['idx']);
            foreach ($hash_tag_data as  $rows){
                $hash_tag .= '#' . $rows['hash_tag'] . ' ';
            }
            $this->data["result"][$key]["hash_tag"] = trim($hash_tag);
//            $this->data["result"][$key]["connect_cnt"] = count($connect_cnt);
        }

        echo json_encode($this->data["result"], JSON_UNESCAPED_UNICODE);
    }


}

?>