$(document).ready(function(){
	Science.init();
});

var Science={
	mainW:$(window).innerWidth(),
	mainH:$(window).innerHeight(),
	mainScienceInfoTop:0,
	init:function () {
		Science.resizeHandler();
		Science.scrollHandler();
		Science.swiperDetailInit();
	},
	resizeHandler:function(){
		$(window).on('resize',function(){
			Science.mainW=$(window).innerWidth();
			Science.mainH=$(window).innerHeight();
		});
	},
	
	scrollHandler:function(){
		// 상단이동버튼
		$('.container').on('scroll',function(){
			var scTop=$(this).scrollTop();
			if($('.top-btn-group').length){
				if(scTop>180){
					gsap.to($('.top-btn-group'),{duration:0.7,opacity:1,visibility:"visible",ease:Power4.easeOut});
				}else{
					gsap.to($('.top-btn-group'),{duration:0.7,opacity:0,visibility:"hidden",ease:Power4.easeOut});
				}
			}
		});

		$(document).on('click','.btn-top',function(){
			$('.container').animate({scrollTop:'0'},300);
		});
		// V 토론 스크롤하면 리스트 늘어남
		$('.debate-body-group').on('scroll',function(){
			var scTop=$('.debate-body-group').scrollTop();
			var containerH=$('.debate-body-group').innerHeight();
			var contentsH=$('.debate-body-group .contents').innerHeight();
			var gap=contentsH-containerH;
/* 			console.log('containerH = ', containerH);
			console.log('contentsH = ', contentsH); */
			console.log('gap = ', gap);
			if (scTop>=gap){
				scrollEnd();
			}
		});
	},

	swiperDetailInit:function(){
		var startX=0,startY=0,curX=0,curY=0;
		$(document).on('touchstart','.swiper-detail',function(e){
			startX = e.originalEvent.touches[0].pageX;
			curX = parseInt(transformValue(target.find('.img-group'), 'x'));
			alert('curX'+curX);
		});

		var moveObj = [], startObj = null, curY = null, gapX = null, gapY = null;
		$(document).off('touchstart', '.swiper-detail').on('touchstart', '.swiper-detail', function (e) {
			moveObj = [0, 0];
			startObj = Science.pageValue(e);
			curX = parseInt(Science.transformValue($(this), 'x')); // transformX
			curY = parseInt(Science.transformValue($(this), 'y')); // transformY
			$(document).on('touchmove', function (e) {
				moveObj = Science.pageValue(e);
				gapX = (parseInt(moveObj[0]) - parseInt(startObj[0]));
				gapY = (parseInt(moveObj[1]) - parseInt(startObj[1]));
			}).one('touchend', function (e) {
				$(this).off('touchmove');
				if(Math.abs(gapY)<50){
					if (gapX < -10) {
						$('.swipe_pass').show();
						swiperAction('pass');
					}
					if (gapX > 10) {
						$('.swipe_like').show();
						swiperAction('like');
					}
				}else if(Math.abs(gapY)>=50){
					/*var offset      = $("#section-detail").offset();
                    var scroll_top  = $(".container").scrollTop() - 70;
                    console.log(scroll_top);
                    $(".container").animate({scrollTop:offset.top + scroll_top},800);*/
                    
				}
			});
		});
	},

	pageValue:function(e, str) {
		if(str == undefined) {
			return [e.originalEvent.touches[0].pageX, e.originalEvent.touches[0].pageY];
		} else {
			return [e.originalEvent.pageX, e.originalEvent.pageY];
		}
	},

	transformValue:function(target, type) {
		if(target != false || target != null || target != undefined) {
			var obj = target;
			var transformMatrix = obj.css('-webkit-transform') || obj.css('-moz-transform') || obj.css('-ms-transform') || obj.css('-o-transform') || obj.css('transform');
			if (transformMatrix == undefined) { return; }
			var matrix = transformMatrix.replace(/[^0-9\-.,]/g, '').split(',');
			var trfX = parseInt(matrix[12] || matrix[4]); // transformX
			var trfY = parseInt(matrix[13] || matrix[5]); // transformY;

			if (type == 'x') { return trfX; }
			else if (type == 'y') { return trfY; }
			else { return trfY; }
		}
	},

	setGnb:function(idx){
		if($('.nav-ul').length){
			$('.nav-ul li .btn-menu').removeClass('on');
			$('.nav-ul li').eq(idx).find('.btn-menu').addClass('on');
		}
	},
	popup: {
		open: function (clickEl, popupID) {
			$('body').append($(popupID));
			$('#wrapper').attr('aria-hidden', 'true'); // 컨텐츠 영역에 포커스 안가도록 함(접근성)
			$('html, body').css('overflow', 'hidden');

			$(popupID).addClass('active');
			$(popupID).find('.popup-content').focus().removeAttr('tabindex');
			gsap.to($(popupID).find('.dim'),{duration:0.5,opacity:1,ease:Power4.easeOut});
			gsap.to($(popupID).find('.popup-content'),{duration:0.5,y:'-100%',ease:Power4.easeOut});

			$(popupID).find('.btn-close').off('click').on('click', function () {
				Science.popup.close(clickEl, popupID);
			});
			$(popupID).find(' ').off('click').on('click', function () {
				$(popupID).find('.btn-close').trigger('click');
			});
		},
		close: function (clickEl, popupID) {
			gsap.to($(popupID).find('.dim'),{duration:0.5,opacity:0,ease:Power4.easeOut});
			gsap.to($(popupID).find('.popup-content'),{duration:0.3,y:'0',ease:Power4.easeOut,onComplete:function(){
				$(popupID).removeClass('active');
				$(popupID).find('.popup-content').attr('tabindex', '-1');
				if ($('.popup-wrap.active').length == 0) {
					$('html, body').removeAttr('style'); // 스크롤 가능
					$('#wrapper').attr('aria-hidden', 'false'); // 컨텐츠 영역에 포커스 가도록 함(접근성)
				}
				if (clickEl == '') {
					$('body').focus();
				} else {
					$(clickEl).focus();
				}
			}});
		}
	},
}