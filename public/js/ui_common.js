$(document).ready(function(){
	Science.init();
	//스크롤 애니메이션
	$(".scroll").click(function(event){    
		event.preventDefault();
		$('html,body').stop().animate({scrollTop:$(this.hash).offset().top - $('header').height()}, 800);
	});
});

var Science={
	mainW:$(window).innerWidth(),
	mainH:$(window).innerHeight(),
	mainScienceInfoTop:0,
	init:function () {
		Science.resizeHandler();
		Science.mainSwiperSize();
		// Science.mainScienceInfo();
		Science.scrollHandler();
	},
	resizeHandler:function(){
		$(window).on('resize',function(){
			Science.mainW=$(window).innerWidth();
			Science.mainH=$(window).innerHeight();
			if($('.main .science-info').length){
				mainScienceInfoTop=$('.main .con-body').offset().top
			}
			Science.mainSwiperSize();

		});
	},
	mainSwiperSize:function(){
		if($('.swiper.main-swiper').length){
			var swiperH=$('.swiper.main-swiper .swiper-slide').innerHeight();
			$('.swiper.main-swiper .swiper-slide').css('width',swiperH*0.75);
			setTimeout(function(){
				var swiperW=$('.swiper.main-swiper .swiper-slide').innerWidth();
				$('.swiper.main-swiper .swiper-button-next').css('margin-left',swiperW/2+21);
				$('.swiper.main-swiper .swiper-button-prev').css('margin-left',-swiperW/2-21);
                console.log(swiperW/2+21);
			},10)
		}
	},
	scrollHandler:function(){
		$(window).on('scroll',function(){
			var sct=$(window).scrollTop();
			mainScienceInfoTop=$('.main .con-body').offset().top;
			if($('.main .science-info').length){
				if (sct > mainScienceInfoTop + 388 - Science.mainH/2 + 120){
					$('.main .science-info').addClass('fixed');
				}else{
					$('.main .science-info').removeClass('fixed');
				}
			}
			if ($('.main .quick-group').length) {
				if (sct > mainScienceInfoTop + 388 - Science.mainH / 2 + 120) {
					$('.main .quick-group').addClass('fixed');
					$('.main .quick-group').css('top');
					gsap.to($('.main .quick-group'),{duration:0.3,opacity:1})
				} else {
					$('.main .quick-group').removeClass('fixed');
					gsap.to($('.main .quick-group'),{duration:0.3,opacity:0})
				}
			}
		});
	},
	setGnb:function(idx){
		if($('.header').length){
			$('.nav-ul li .btn-menu').removeClass('on');
			$('.nav-ul li').eq(idx).find('.btn-menu').addClass('on');
			$('.btn-logo').removeClass('on');
			$('.btn-logo').eq(idx).find('.btn-logo').addClass('on');
		}
	},
	popup: {
		open: function (clickEl, popupID) {
			$('body').append($(popupID));
			$('#wrapper').attr('aria-hidden', 'true'); // 컨텐츠 영역에 포커스 안가도록 함(접근성)
			$('html, body').css('overflow', 'hidden');

			$(popupID).addClass('active');
			$(popupID).find('.popup-content').focus().removeAttr('tabindex');

			$(popupID).find('.btn-close').off('click').on('click', function () {
				Science.popup.close(clickEl, popupID);
			});
			$(popupID).find(' ').off('click').on('click', function () {
				$(popupID).find('.btn-close').trigger('click');
			});
		},
		close: function (clickEl, popupID) {
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
		}
	},
	
}



//스크롤탑 이동
function scrollUp(){
	$('html, body').animate({scrollTop: 0}, 600, function(){
		scroll_flag   = false;
	});
}


//새로고침
$(document).on("click",".do-refresh", function (){
	setTimeout(function(){
		location.reload();
	},3000);
});
