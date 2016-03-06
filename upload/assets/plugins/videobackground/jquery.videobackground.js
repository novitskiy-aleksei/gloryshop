/*!
 * jQuery Video Background plugin
 * https://github.com/georgepaterson/jquery-videobackground
 *
 * Copyright 2012, George Paterson
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 */
!function(t,i,o){"use strict";function e(e){var n=t(i).height(),s=t(o).height();"window"===e.settings.resizeTo?t(e).css("height",s):s>=n?t(e).css("height",s):t(e).css("height",n)}function n(i){t(i.controlbox).append(i.settings.preloadHtml),i.settings.preloadCallback&&i.settings.preloadCallback.call(i)}function s(i){var o,e=i.find("video").get(0);o=i.settings.controlPosition?t(i.settings.controlPosition).find(".ui-video-background-play a"):i.find(".ui-video-background-play a"),e.paused?(e.play(),o.toggleClass("ui-icon-pause ui-icon-play").html(i.settings.controlText[1])):e.ended?(e.play(),o.toggleClass("ui-icon-pause ui-icon-play").html(i.settings.controlText[1])):(e.pause(),o.toggleClass("ui-icon-pause ui-icon-play").html(i.settings.controlText[0]))}function a(i){var o,e=i.find("video").get(0);o=i.settings.controlPosition?t(i.settings.controlPosition).find(".ui-video-background-mute a"):i.find(".ui-video-background-mute a"),0===e.volume?(e.volume=1,o.toggleClass("ui-icon-volume-on ui-icon-volume-off").html(i.settings.controlText[2])):(e.volume=0,o.toggleClass("ui-icon-volume-on ui-icon-volume-off").html(i.settings.controlText[3]))}function l(i){i.settings.resize&&t(o).on("resize",function(){e(i)}),i.controls.find(".ui-video-background-play a").on("click",function(t){t.preventDefault(),s(i)}),i.controls.find(".ui-video-background-mute a").on("click",function(t){t.preventDefault(),a(i)}),i.settings.loop&&i.find("video").on("ended",function(){t(this).get(0).play(),t(this).toggleClass("paused").html(i.settings.controlText[1])})}function d(i){t(i.controlbox).html(i.controls),l(i),i.settings.loadedCallback&&i.settings.loadedCallback.call(i)}var c={init:function(o){return this.each(function(){var s,a,l=t(this),c="",u="",r=l.data("video-options");i.createElement("video").canPlayType?(l.settings=t.extend(!0,{},t.fn.videobackground.defaults,r,o),l.settings.initialised||(l.settings.initialised=!0,l.settings.resize&&e(l),t.each(l.settings.videoSource,function(){a="[object Array]"===Object.prototype.toString.call(this),c=a&&void 0!==this[1]?c+'<source src="'+this[0]+'" type="'+this[1]+'">':a?c+'<source src="'+this[0]+'">':c+'<source src="'+this+'">'}),u=u+'preload="'+l.settings.preload+'"',l.settings.poster&&(u=u+' poster="'+l.settings.poster+'"'),l.settings.autoplay&&(u+=' autoplay="autoplay"'),l.settings.loop&&(u+=' loop="loop"'),l.settings.muted&&(u+=' muted="muted"'),t(l).html("<video "+u+">"+c+"</video>"),l.controlbox=t('<div class="ui-video-background ui-widget ui-widget-content ui-corner-all"></div>'),l.settings.controlPosition?t(l.settings.controlPosition).append(l.controlbox):t(l).append(l.controlbox),l.controls=t('<ul class="ui-video-background-controls"><li class="ui-video-background-play"><a class="ui-icon ui-icon-pause" href="#">'+l.settings.controlText[1]+'</a></li><li class="ui-video-background-mute"><a class="ui-icon ui-icon-volume-on" href="#">'+l.settings.controlText[2]+"</a></li></ul>"),l.settings.preloadHtml||l.settings.preloadCallback?(n(l),l.find("video").on("canplaythrough",function(){l.settings.autoplay&&l.find("video").get(0).play(),d(l)})):l.find("video").on("canplaythrough",function(){l.settings.autoplay&&l.find("video").get(0).play(),d(l)}),l.data("video-options",l.settings))):(l.settings=t.extend(!0,{},t.fn.videobackground.defaults,r,o),l.settings.initialised||(l.settings.initialised=!0,l.settings.poster&&(s=t('<img class="ui-video-background-poster" src="'+l.settings.poster+'">'),l.append(s)),l.data("video-options",l.settings)))})},play:function(i){return this.each(function(){var o=t(this),e=o.data("video-options");o.settings=t.extend(!0,{},e,i),o.settings.initialised&&(s(o),o.data("video-options",o.settings))})},mute:function(i){return this.each(function(){var o=t(this),e=o.data("video-options");o.settings=t.extend(!0,{},e,i),o.settings.initialised&&(a(o),o.data("video-options",o.settings))})},resize:function(i){return this.each(function(){var o=t(this),n=o.data("video-options");o.settings=t.extend(!0,{},n,i),o.settings.initialised&&(e(o),o.data("video-options",o.settings))})},destroy:function(e){return this.each(function(){var n=t(this),s=n.data("video-options");n.settings=t.extend(!0,{},s,e),n.settings.initialised&&(n.settings.initialised=!1,i.createElement("video").canPlayType?(n.find("video").off("ended"),n.settings.controlPosition?(t(n.settings.controlPosition).find(".ui-video-background-mute a").off("click"),t(n.settings.controlPosition).find(".ui-video-background-play a").off("click")):(n.find(".ui-video-background-mute a").off("click"),n.find(".ui-video-background-play a").off("click")),t(o).off("resize"),n.find("video").off("canplaythrough"),n.settings.controlPosition?t(n.settings.controlPosition).find(".ui-video-background").remove():n.find(".ui-video-background").remove(),t("video",n).remove()):n.settings.poster&&n.find(".ui-video-background-poster").remove(),n.removeData("video-options"))})}};t.fn.videobackground=function(i){return this.length?c[i]?c[i].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof i&&i?void t.error("Method "+i+" does not exist on jQuery.videobackground"):c.init.apply(this,arguments):this},t.fn.videobackground.defaults={videoSource:[],poster:null,autoplay:!0,preload:"auto",loop:!1,controlPosition:null,controlText:["Play","Pause","Mute","Unmute"],resize:!0,preloadHtml:"",preloadCallback:null,loadedCallback:null,resizeTo:"document"}}(jQuery,document,window);
//---------------------------------------------> HTML5 Video Background  Init
$(document).ready(function(){
	$('.html_video_background').each(function(index, element) {
		var mp4 = $(this).attr("data-mp");
		var webm = $(this).attr("data-webm");
		var ogg = $(this).attr("data-ogg");
		var poster = $(this).attr("data-poster");
		var controll_pos = $(this).parent().find(".video_frame_bl");
		var resize_to = $(this).parent();
		
		$(this).videobackground({
			videoSource: [
				[mp4, 'video/mp4'],
				[webm, 'video/webm'], 
				[ogg, 'video/ogg']
			], 
			controlPosition: controll_pos,
			poster: poster,
			loadedCallback: function() {
				$(this).videobackground('mute');
			},
			loop: true,
			controlText : [
				['<span class="html5_video_play"><i class="fa fa-play3"></i></span>'],
				['<span class="html5_video_pause"><i class="fa fa-pause2"></i></span>'],
				['<span class="html5_video_pause"><i class="fa fa-sound4"></i></span>'],
				['<span class="html5_video_pause"><i class="fa fa-sound-mute"></i></span>']
			],
			resizeTo: '.html_video_background'
		});
	});
});