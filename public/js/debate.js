$(function(){

    var iframe      = document.getElementById('chat').contentWindow;
    $(document).on("click", ".edit_wrap .btn_like", function () {
        if( $(this).hasClass("on") ){
            $(this).removeClass("on");
        }else{
            $(this).addClass("on");
        }
    });

    $(document).on("click", ".edit_wrap .btn_book", function () {
        if( $(this).hasClass("on") ){
            $(this).removeClass("on");
        }else{
            $(this).addClass("on");
        }
    });


    $(document).on("click", ".btn-play", function () {
        var file_src = $(this).attr('data-src');
        Chat.play(file_src);
    });

    Chat.getChatHistory();

});

function roomClose(){

    var room_idx = $("#room_idx").val();
    if(confirm("토론방을 종료 하시겠습니까?")){
        $.ajax({
            url         : "/debate/closeDebateRoom",
            type        : "POST",
            data        : {"room_idx": room_idx},
            dataType    : "JSON",
            success     : function (result) {
                if( result.status == "success" ){
                    location.href = '/debate/index';
                }
            }
        });
    }
}

var Chat = {

    sendMessage: function (duration, file_path, type){
        var user_idx = $("#user_idx").val();
        var room_idx = $("#room_idx").val();
        var message  = $.trim($("#message").val());
        var today    = new Date();
        var year     = today.getFullYear();
        var month    = ('0' + (today.getMonth() + 1)).slice(-2);
        var day      = ('0' + today.getDate()).slice(-2);
        var hours = ('0' + today.getHours()).slice(-2);
        var minutes = ('0' + today.getMinutes()).slice(-2);
        var seconds = ('0' + today.getSeconds()).slice(-2);
        var dateString = year + '-' + month  + '-' + day + ' ' + hours + ':' + minutes  + ':' + seconds;

        $.ajax({
            url         : "/debate/getUser",
            type        : "POST",
            data        : {"user_idx" :  user_idx},
            dataType    : "JSON",
            success     : function (result) {
                if (result.status == 'success'){

                    if (type == 'voice'){
                        message = "voice|" + user_idx + "|"+ result['user_name']  + "|" + duration + "|" + dateString + "|" + file_path;
                        var params = {
                            'message': message,
                            'action': 'message',
                        };

                        // var iframe = $('iframe').get(0).contentWindow;
                        var iframe = document.getElementById('chat').contentWindow;
                        iframe.postMessage({ parentData : params}, 'https://www.scitalks.co.kr:3000');
                    }else{
                        $.ajax({
                            url         : "/debate/insertMessage",
                            type        : "POST",
                            data        : {"message" :  message, "room_idx" : room_idx},
                            dataType    : "JSON",
                            success     : function () {
                                message = "text|" + user_idx + "|"+ result['user_name']  + "|"  + "|" + dateString+ "|" + message ;
                                var params = {
                                    'message': message,
                                    'action': 'message',
                                };
                                // var iframe = $('iframe').get(0).contentWindow;
                                var iframe = document.getElementById('chat').contentWindow;
                                iframe.postMessage({ parentData : params}, 'https://www.scitalks.co.kr:3000');
                            }
                        });
                    }

                }

            }
        });

    },

    displayChatMessage: function (user_idx, message){

        // var arr     = message.split('|');


        var html    = "";
        var my_idx  = $('#user_idx').val();

        if (message['type'] == 'voice'){

            if (user_idx != my_idx){
                html += '<li class="anyone">';
                html += '    <div class="voicechat-group anyone">';
                html += '       <div class="name">' + message['user_name']  +'</div>';
                html += '       <button type="button" class="btn-play" data-src="' + message['message']+'"><span>' + message['duration'] +'</span></button>';
                html += '       <div class="time">';
                html += '            <span>' + message['reg_date'] +' </span>';
                html += '        </div>';
                html += '    </div>';
                html += '</li>';
            }else{

                html += '<li class="me">';
                html += '    <div class="voicechat-group me">';
                html += '        <div class="time">';
                html += '            <span>' + message['reg_date'] +'</span>';
                html += '        </div>';
                html += '        <button type="button" class="btn-play" data-src="' + message['message'] +'"><span>' +  message['duration'] +'</span></button>';
                html += '        <div class="name">' + message['user_name'] +'</div>';
                html += '    </div>';
                html += '</li>';
            }
        }else{

            if (user_idx != my_idx) {
                html += '<li class="text_anyone">';
                html += '    <div class="voicechat-group text_anyone">';
                html += '        <div class="name">' + message['user_name'] +'</div>';
                html += '        <p class="txt_chat"><span>' + message['message']+'</span>';
                html += '        </p>';
                html += '        <div class="time"><span>' + message['reg_date'] +'</span></div>';
                html += '    </div>';
                html += '</li>';
            }else{

                html += '<li class="text_me">';
                html += '    <div class="voicechat-group text_me">';
                html += '        <div class="time"><span>' + message['reg_date'] +'</span></div>';
                html += '        <p class="txt_chat"><span>' + message['message']  +'</span></p>';
                html += '        <div class="name">' + message['user_name'] +'</div>';
                html += '    </div>';
                html += '</li>';
            }
        }

        $("#message_ul").append(html);
        const chatMessages = document.querySelector('#message_ul');
        chatMessages.scrollTop = chatMessages.scrollHeight;

    },
    getChatHistory: function(){
        var room_idx = $("#room_idx").val();
        var message  = [];
        $.ajax({
            url         : "/debate/debateMessageList",
            type        : "POST",
            data        : {"room_idx" :  room_idx},
            dataType    : "JSON",
            success     : function (result) {
                var html = '';
                $.each(result,function(i,value){
                    // console.log(value)
                    var user_idx            = value['user_idx'];
                    message['type']         = value['type'];
                    message['user_idx']     = value['user_idx'];
                    message['user_name']    = value['name'];
                    message['duration']     = value['duration'];
                    message['reg_date']     = value['reg_date'];
                    message['message']      = value['message'];
                    Chat.displayChatMessage(user_idx, message);
                });
            }
        });
    },

    leaveRoom: function(){
        if (confirm('토론방을 나가시겠습니까?')){
            location.href = '/debate/index';
        }
    },

    play: function(file_src){
        var audio = document.querySelector('.audio');
        var num = 0;
        var src = [];
        if (file_src != ''){
            src = [file_src];
            audio.src = src[0]
            audio.play();
        }else{
            var room_idx = $("#room_idx").val();
            $.ajax({
                url         : "/debate/getMessage",
                type        : "POST",
                data        : {"room_idx" :  room_idx},
                dataType    : "JSON",
                success     : function (result) {
                    if (result.status == 'success') {

                        $.each(result.message,function(i,value){
                            src.push(value['message']);
                        })

                        audio.src = src[0]
                        audio.play();
                        audio.addEventListener('ended',function(){
                            // num = (num + 1) % src.length;
                            num++;

                            if (num < src.length){
                                audio.src = src[num]
                                audio.play();
                            }
                        });

                    }

                }
            });

        }
    },
    checkUser: function(){
        var room_idx = $("#room_idx").val();

        $.ajax({
            url         : "/debate/checkUser",
            type        : "POST",
            data        : {"room_idx" :  room_idx},
            dataType    : "JSON",
            success     : function (result) {

                if (result.status == 'success'){
                    $('#user_list').html('');
                    var html = '';
                    $.each(result.users,function(i,value){
                        html += '<p id="connect_user_' + value['idx'] +'">' + value['name'] + '</p>';
                    })
                    $('#user_list').append(html)
                }
            }
        });
    },
    checkLike: function(){

        var room_idx = $("#room_idx").val();

        if ($(".btn_like").hasClass('on')){
            var status   = 0;
            $(".btn_like").removeClass('on');
        }else{
            var status   = 1;
            $(".btn_like").addClass('on');
        }

        $.ajax({
            url         : "/debate/checkLike",
            type        : "POST",
            data        : {"room_idx" :  room_idx,"status" :  status},
            dataType    : "JSON",
            success     : function (result) {

            }
        });
    },
    checkBookMark: function (){
        var room_idx = $("#room_idx").val();
        if ($(".btn_book").hasClass('on')){
            var status   = 0;
            $(".btn_book").removeClass('on');
        }else{
            var status   = 1;
            $(".btn_book").addClass('on');
        }

        $.ajax({
            url         : "/debate/checkBookmark",
            type        : "POST",
            data        : {"room_idx" :  room_idx,"status" :  status},
            dataType    : "JSON",
            success     : function (result) {

            }
        });
    }
}

function sendMessage(duration, file_path){
    Chat.sendMessage(duration, file_path, 'voice');
}

function sendMessageText(){
    var message = $.trim($("#message").val());
    if (message == ''){
        alert('메세지를 입력해 주세요.');
    }else{
        Chat.sendMessage('', '', 'text');
        $("#message").val('');
    }

}



function enterkey(){

    if (window.event.keyCode == 13) {
        var message = $.trim($("#message").val());
        if (message != ''){
            Chat.sendMessage('', '', 'text');
            $("#message").val('');
        }
    }
}


window.addEventListener('message', function(e) {

    //참여자 리스트 처리
    if (e.data.hasOwnProperty('users')){
        Chat.checkUser();
    }
    else if (e.data.hasOwnProperty('action')){

        if (e.data.action == 'message'){

            $.ajax({
                url         : "/debate/getUser",
                type        : "POST",
                data        : {"user_idx" :  e.data.username},
                dataType    : "JSON",
                success     : function (result) {
                    if (result.status == 'success'){
                        var message             = [];

                        var data_arry           = e.data.message.split('|', 6)
                        message['type']         = data_arry[0];
                        message['user_idx']     = data_arry[1];
                        message['user_name']    = data_arry[2];
                        message['duration']     = data_arry[3];
                        message['reg_date']     = data_arry[4];
                        message['message']      = data_arry[5];


                        Chat.displayChatMessage(e.data.username, message);
                    }

                }
            });
        }
        else if (e.data.action == 'disconnect' || e.data.action == 'connect'|| e.data.action == 'join'){
            Chat.checkUser();
        }

    }
});
