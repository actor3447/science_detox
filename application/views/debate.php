

<script>
    $(function(){



        Debate.init(<?=json_encode($category)?>);

    })

</script>



<div class="contents">
    <div class="con-group">
        <div class="con-heading">
            <h2 class="h2 loc-center">
                <img src="/public/images/bg_debate.png" alt="V토론 관심분야토론에 참여해 보세요./">
            </h2>
        </div>
        <div class="con-body loc-center">

            <?foreach ($category as $cate):?>
            <input type="hidden" id="page_<?=$cate['idx']?>" name="page_<?=$cate['idx']?>" value="">
            <div class="header-group">
                <h4 class="h4 darkgray"><?=$cate['title']?></h4>
            </div>


            <!-- 토론 리스트 -->
            <ul class="debate-lists" id="debate-list-<?=$cate['idx']?>">

                <li class="ing">
                    <div class="debate-group">
                        <div class="debate-heading">
                            <div class="debate-flag">토론진행중</div>
                            <img src="/public/images/thumb_debate0.png" alt="">
                        </div>
                        <div class="debate-body">
                            <div class="dbbody-top">
                                <div class="dbbody-left">카테고리 명</div>
                                <div class="dbbody-right">8</div>
                            </div>
                            <p class="dbbody-middle">
                                안락사 제도에 대해 어떻게 생각하시나요?
                            </p>
                        </div>
                    </div>
                    <div class="debate-footer flex-center">
                        <a href="javascript:;" class="btn-primary"><span>토론 참여 하기</span></a>
                    </div>
                </li>
                <li class="ing">
                    <div class="debate-group">
                        <div class="debate-heading">
                            <div class="debate-flag">토론진행중</div>
                            <img src="/public/images/thumb_debate1.png" alt="">
                        </div>
                        <div class="debate-body">
                            <div class="dbbody-top">
                                <div class="dbbody-left">카테고리 명</div>
                                <div class="dbbody-right">8</div>
                            </div>
                            <p class="dbbody-middle">
                                전 세계적으로 문제가 되는 산불, 방지하기 위한 과학적 방법은 뭐가 있을까요?
                            </p>
                        </div>
                    </div>
                    <div class="debate-footer flex-center">
                        <a href="javascript:;" class="btn-primary"><span>토론 참여 하기</span></a>
                    </div>
                </li>
                <li class="end">
                    <div class="debate-group">
                        <div class="debate-heading">
                            <div class="debate-flag">토론 종료</div>
                            <img src="/public/images/thumb_debate2.png" alt="">
                        </div>
                        <div class="debate-body">
                            <div class="dbbody-top">
                                <div class="dbbody-left">카테고리 명</div>
                                <div class="dbbody-right">8</div>
                            </div>
                            <p class="dbbody-middle">
                                6명중 1명이 격는 심각한 식량 위기, 어떻게 극복 할수 있을까요?
                            </p>
                        </div>
                    </div>
                    <div class="debate-footer flex-center">
                        <a href="javascript:;" class="btn-secondary"><span>토론 다시 보기</span></a>
                    </div>
                </li>
            </ul>
            <!-- // 토론 리스트 -->

            <div class="btn-group">
                <button  class="btn-more" onclick="">
                    <span>더보기</span>
                </button>
            </div>

            <?endforeach;?>


            <!-- QUICK -->
            <div class="quick-group">
                <button  class="btn-debate-make"><span>토론방<br>만들기</span></button>
                <button  class="btn-quick do-refresh" title="리플래시"></button>
                <a href="#header" class="btn-quick do-top" title="탑으로 이동"></a>
            </div>
            <!-- // QUICK -->
        </div>
    </div>
</div>