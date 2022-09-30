jQuery(function( $ ) {
	'use strict';
	var times = vt_ajax.visit_times;
	var timer = null;
	var is_done = false;
	var idleTimes = 4000;

	$(document).on("click", ".minmaxbtn", function(){
		$("div#vt_view").toggleClass("_minimize");
		$(this).toggleClass("_minimize_btn");
	});
	
	if(parseInt($("input[name='vt_visits']").val()) === parseInt(vt_ajax.visit_pages) || parseInt($("input[name='vt_visits']").val()) > parseInt(vt_ajax.visit_pages)){
		$(".vt_alerts").text("Now you can copy the code to complete the mission.");
	}

	function timer_is_finished(){
		$.ajax({
			type: "post",
			url: vt_ajax.ajaxurl,
			data: {
				action: "save_visits",
				post: $("input[name='vt_post_id']").val()
			},
			dataType: "json",
			success: function (response) {
				$(".page_visits").text(response.success);

				if(parseInt(response.success) === parseInt(vt_ajax.visit_pages)){
					$(".vt_alerts").text("Click on one Ad and visit 3 more pages within the same Ad.");
					$(".hiddenAlert").append('<h3>Time will still run backwards if you close this website<br>Please click on the banner ad honestly.</h3>');
					countTimer(60);
				}else{
					$(".vt_alerts").text("Please visit other pages.");
				}
				
			}
		});
	}

	function countTimer(max, is_update = false){
		let htmlView = $(".run_timer");
		times = max;
		
		timer = setInterval(() => {
			if(times > 0){
				times--;
				if(times > 1){
					htmlView.text(times+" seconds");
				}else{
					htmlView.text(times+" second");
				}
			}else{
				is_done = true;
				clearInterval(timer);
				if(is_update){
					timer_is_finished();
				}else{
					$.ajax({
						type: "get",
						url: vt_ajax.ajaxurl,
						data: {
							action: "get_unique_code"
						},
						dataType: "json",
						success: function (response) {
							$(".hiddenAlert").html("");
							$(".vt_alerts").text("Now you can copy the code to complete the mission.");
							$(".hiddenCode").html(`Code: <code>${response.success}</code>`);
						}
					});
				}
			}
		}, 1000);
	}

	function start_visiting(){
		countTimer(times, true)
	
		let is_start = true;
		let is_crolling = false;
		setTimeout(() => {
			if(!is_crolling){
				// Stop Timer
				if(!is_done){
					$(".vt_alerts").text("Don't idle too long, please scroll.");
					clearInterval(timer);
					is_start = false;
				}
			}
		}, idleTimes);
	
		$(window).scroll(function() {
			if(!is_start){
				$(".vt_alerts").text("");
				countTimer(times, true);
				is_start = true;
			}
	
			clearTimeout($.data(this, 'scrollTimer'));
			$.data(this, 'scrollTimer', setTimeout(function() {
				// Stop Timer
				if(!is_done){
					if(times > 0){
						$(".vt_alerts").text("Don't idle too long, please scroll.");
						clearInterval(timer);
						is_start = false;
					}
				}
			}, idleTimes));
		});
	}

	if(parseInt($("input[name='vt_visits']").val()) < parseInt(vt_ajax.visit_pages)){
		if($("input[name='is_page_visits']").val() === 'yes'){
			$(".vt_alerts").text("This page is already visited.");
		}else{
			start_visiting();
		}
	}
});
