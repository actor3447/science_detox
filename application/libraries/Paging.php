<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paging {
    var $base_url	= '';
    var $tot_row	= 0;
    var $cur_page 	= 1;
    var $size		= 20;
    var $block 		= 10;
    var $model 		= '';
    var $model_func	= '';

    // var $pre_blk	= '<<';
    // var $nxt_blk	= '>>';

    // var $pre_blk	= '<img src="/web/images/admin/btn_paging_prev.gif" width="12" height="13" alt="이전"/>';
    // var $nxt_blk	= '<img src="/web/images/admin/btn_paging_next.gif" width="12" height="13" alt="다음"/>';
    var $addParam	= '';

    function __construct($conf = array()){
        if(count($conf)>0){
            $this->init($conf);
        }
    }

    function init($params = array()){
        if (count($params) > 0){
            foreach ($params as $key => $val){
                if (isset($this->$key)){
                    $this->$key = $val;
                }
            }
        }
    }

                        

    public function createPage(){

        $rtn 			= '<ul class="pagination justify-content-center">';

        if ($this->tot_row > 0){

            $cur_blk 	= ceil($this->cur_page / $this->block);
            $tot_page 	= ceil($this->tot_row / $this->size);
            $tot_blk	= ceil($tot_page / $this->block);

            $baseURL	= rtrim($this->base_url, '/');
            $addURL		= ltrim($this->addParam, '/');

            $connect	= strpos($baseURL,'?')?'&':'?';

            if($cur_blk > 1){
                $rtn .= '<li class="page-item previous"><a class="page-link" href="'.$baseURL.$connect.'page='.(($cur_blk-2)*$this->block + 1).'" >«</a></li>';

            } else {
                $rtn .= '<li class="page-item previous disabled"><a class="page-link" href="javascript:;">«</a></span>';
            }

            $page = ($cur_blk-1)*$this->block + 1;
            while($page <= $tot_page && $page <= ($cur_blk*$this->block)){
                if($page == $this->cur_page){
                    $rtn .= '<li class="paginate_button page-item  active"><a class="page-link" href="javascript:;">'.$page.'</li>';
                } else {
                    $rtn .= '<li class="paginate_button page-item "><a class="page-link" href="'.$baseURL.$connect.'page='.$page.'">'.$page.'</a></li>';
                }
                $page++;
            }

            if($cur_blk < $tot_blk){
                $rtn .= '<li class="page-item next"><a class="page-link" href="'.$baseURL.$connect.'page='.(($cur_blk)*$this->block + 1).'" >»</a></li>';
            } else {
                $rtn .= '<li class="page-item next disabled"><a class="page-link" href="javascript:;" >»</a></li>';
            }

        }
        return $rtn .= '</ul>';
    }



    public function createFrontPage($size=20){

        $rtn 			= '';

        if ($this->tot_row > 0){

            $cur_blk 	= ceil($this->cur_page / $this->block);
            $tot_page 	= ceil($this->tot_row / $this->size);
            $tot_blk	= ceil($tot_page / $this->block);

            $baseURL	= rtrim($this->base_url, '/');
            $addURL		= ltrim($this->addParam, '/');

            $connect	= strpos($baseURL,'?')?'&':'?';

//            $rtn .= '<a href="'.$baseURL.$connect. 'page=1" ><img src="/public/images/icon_pager_first.png" alt="처음으로"/></a></li>';
            if($cur_blk > 1){

                $rtn .= '<a href="'.$baseURL.$connect.'page='.(($cur_blk-2)*$this->block + 1).'" class="first" ><img src="/public/images/arrow_prev.png" alt="이전" /></a>';

            } else {
                $rtn .= '<a href="javascript:;" class="first"><img src="/public/images/arrow_prev.png" alt="이전" /></a></li>';
            }

            $page = ($cur_blk-1)*$this->block + 1;
            while($page <= $tot_page && $page <= ($cur_blk*$this->block)){
                if($page == $this->cur_page){
                    $rtn .= '<a href="javascript:;" class="active">'.$page.'</a>';
                } else {
                    $rtn .= '<a href="'.$baseURL.$connect.'page='.$page.'" >'.$page.'</a>';
                }
                $page++;
            }

            if($cur_blk < $tot_blk){
                $rtn .= '<a href="'.$baseURL.$connect.'page='.(($cur_blk)*$this->block + 1). '" class="last" ><img src="/public/images/arrow_next.png" alt="다음" /></a>';

            } else {
                $rtn .= '<a href="javascript:;" class="last" ><img src="/public/images/arrow_next.png" alt="다음" /></a>';
            }
//            $rtn .= '<li class="last"><a href="'.$baseURL.$connect.'page='.$tot_page.'" ><img src="/public/images/icon_pager_last.png" alt="끝으로"/></a></li>';


        }
        return $rtn .= '';
    }




    public function createFrontPageDiv(){

        $rtn 			= '';

        if ($this->tot_row > 0){

            $cur_blk 	= ceil($this->cur_page / $this->block);
            $tot_page 	= ceil($this->tot_row / $this->size);
            $tot_blk	= ceil($tot_page / $this->block);

            if($cur_blk > 1){
                $rtn .= '<a href="javascript:parent.goPage(' . (($cur_blk-2)*$this->block + 1) .')" class="first"><img src="/public/images/arrow_prev.png" alt="이전"></a>';

            } else {
                $rtn .= '<a href="javascript:;" class="first"><img src="/public/images/arrow_prev.png" alt="이전"></a>';
            }

            $page = ($cur_blk-1)*$this->block + 1;
            while($page <= $tot_page && $page <= ($cur_blk*$this->block)){
                if($page == $this->cur_page){
                    $rtn .= '<a href="javascript:;" class="active">'.$page.'</a>';
                } else {
                    $rtn .= '<a href="javascript:parent.goPage('.$page.')">'.$page.'</a>';
                }
                $page++;
            }

            if($cur_blk < $tot_blk){
                $rtn .= '<a href="javascript:parent.goPage('.(($cur_blk)*$this->block + 1).')" class="last"><img src="/public/images/arrow_next.png" alt="다음"></a>';
            } else {
                $rtn .= '<a href="javascript:;" class="last" ><img src="/public/images/arrow_next.png" alt="다음" /></a>';
            }

        }
        return $rtn;
    }

    function createPaging(){
        if(is_numeric($this->cur_page)) {
            $rtn 			= '';
            $rtn 			.= '<ul>';
            if ($this->tot_row > 0){

                $cur_blk 	= ceil($this->cur_page / $this->block);
                $tot_page 	= ceil($this->tot_row / $this->size);
                $tot_blk	= ceil($tot_page / $this->block);
                $prev_btn   = $this->cur_page - 1;
                $next_btn   = $this->cur_page + 1;
//                    $type       = "'".$staff_type."'";
                $baseURL	= rtrim($this->base_url, '/');
                $connect	= strpos($baseURL,'?')?'&':'?';

                if($cur_blk > 1){
                    $rtn .= '<li class="first 1"><a href="'.$baseURL.$connect.'page='. 1 .'"><img src="/public/admin/images/icon_pager_first.png" alt="맨 처음" /></a></li>';
                    $rtn .= '<li class="first"><a href="'.$baseURL.$connect.'page='. $prev_btn .'"><img src="/public/admin/images/icon_pager_prev.png" alt="맨처음" /></a></li>';
                } else {
                    if($prev_btn > 0){
                        $rtn .= '<li class="first 2"><a href="'.$baseURL.$connect.'page='. 1 .'"><img src="/public/admin/images/icon_pager_first.png" alt="맨 처음" /></a></li>';
                        $rtn .= '<li class="prev"><a href="'.$baseURL.$connect.'page='. $prev_btn .'"><img src="/public/admin/images/icon_pager_prev.png" alt="이전페이지" /></a></li>';
                    } else {
                        $rtn .= '<li class="first"><a href="javascript:;"><img src="/public/admin/images/icon_pager_first.png" alt="맨 처음" /></a></li>';
                        $rtn .= '<li class="prev"><a href="javascript:;"><img src="/public/admin/images/icon_pager_prev.png" alt="이전페이지" /></a></li>';
                    }

                }

                $page = ($cur_blk-1)*$this->block + 1;
                while($page <= $tot_page && $page <= ($cur_blk*$this->block)){
                    if($page == $this->cur_page){
                        $rtn .= '<li class="active" data="'.$this->base_url.'"><a href="javascript:;">'.$page.'</a></li>';
                    } else {
                        $rtn .= '<li class=""><a href="'.$baseURL.$connect.'page='. $page .'">'.$page.'</a></li>';
                    }
                    $page++;
                }

                if($cur_blk < $tot_blk){
                    $rtn .= '<li class="next"><a href="'.$baseURL.$connect.'page='. $next_btn .'"><img src="/public/admin/images/icon_pager_next.png" alt="다음페이지" /></a></li>';
                    $rtn .= '<li class="last"><a href="'.$baseURL.$connect.'page='. $tot_page .'"><img src="/public/admin/images/icon_pager_last.png" alt="맨끝" /></a></li>';
                } else {
                    if($next_btn < $tot_page+1){
                        $rtn .= '<li class="next"><a href="'.$baseURL.$connect.'page='. $next_btn .'"><img src="/public/admin/images/icon_pager_next.png" alt="다음페이지" /></a></li>';
                        $rtn .= '<li class="last"><a href="'.$baseURL.$connect.'page='. $tot_page .'"><img src="/public/admin/images/icon_pager_last.png" alt="맨끝" /></a></li>';
                    } else {
                        $rtn .= '<li class="next"><a href="javascript:;"><img src="/public/admin/images/icon_pager_next.png" alt="다음페이지" /></a></li>';
                        $rtn .= '<li class="last"><a href="javascript:;"><img src="/public/admin/images/icon_pager_last.png" alt="맨끝" /></a></li>';
                    }
                }

            }
            $rtn                .= '</ul>';
            return $rtn;
        }
    }

}
?>