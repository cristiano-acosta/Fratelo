/************************************************************************************************************************************
 *	neosmart STREAM - js core
 *
 *	@copyright:			neosmart GmbH
 *	@licence:			https://neosmart-stream.de/legal/license-agreement/
 *	@documentation:		https://neosmart-stream.de/docs/
 *	@version:			1.0.0
 *	
 ************************************************************************************************************************************/
(function(a){a.fn.neosmartStream=function(j){var b=a.extend({},a.fn.neosmartStream.defaults,j);var e=this;b.uid=false;b.uat=false;b.dev=true;i();function i(){if(!b.auto_update){return}a.ajax({url:b.path+"nss-core/ajax.config.php",complete:function(m,k){var l=a.parseJSON(m.responseText);b.cache_time=parseInt(l.cache_time);b.channel_count=parseInt(l.channel_count);if(l.update=="true"){h()}else{if(b.dev){return false}setTimeout(h,b.cache_time*1000)}}})}function h(){b.updated_count=0;for(var k=0;k<b.channel_count;k++){g(k)}}function g(k){a.ajax({url:b.path+"nss-core/ajax.update.channel.php?channel="+k,complete:function(n,l){var m=a.parseJSON(n.responseText);if(m){d(m.channel,m.status)}else{d(k,"error")}}})}function d(l,k){b.updated_count++;if(b.updated_count==b.channel_count){c()}}function c(){a.ajax({url:b.path+"nss-core/ajax.merge.channels.php",complete:function(l,k){f(l.responseText)}})}function f(k){if(b.dev){return false}setTimeout(h,b.cache_time*1000)}return e};a.fn.neosmartStream.defaults={cache_time:60,channel_count:0,updated_count:0,auto_update:true,dev:false,path:"neosmart-stream/"}})(jQuery);