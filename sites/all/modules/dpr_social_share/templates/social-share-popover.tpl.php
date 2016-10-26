<?php
/**
* Created by 
 * User: aisstr
* Date: 21/10/2016
* Time: 10:00 UTC+02:00
*/

$facebookAppId = variable_get('dpr_social_share_facebook_app_id', "");
$instagramUrl = variable_get('dpr_social_share_instagram_url', "");

// count the number of active social media channels
$socialmedia = array(
    variable_get('dpr_social_share_facebook_enabled', TRUE),
    variable_get('dpr_social_share_twitter_enabled', TRUE),
    variable_get('dpr_social_share_google_enabled', TRUE),
    variable_get('dpr_social_share_instagram_enabled', TRUE));
$number_of_icons = count(array_filter($socialmedia));
// determine the width of popover based on the number of icons that will be placed in
$popover_width;
switch($number_of_icons){
    case 1:
    $popover_width = "one-icon";
    break;
    case 2:
    $popover_width = "two-icons";
    break;
    case 3:
    $popover_width = "three-icons";
    break;
    case 4:
    $popover_width = "four-icons";
    break;
    default:
    $popover_width = "four-icons";
}

?>

<script language="javascript">
    (function ($) {
        $(function() {
            $("[rel=socialmedia]").on("mouseenter", function(){
                var url = $(this).data("content-url");
                var title = $(this).data("content-title");
                var content = '<div class="socialmedia-image">'+
                        <?php if (variable_get('dpr_social_share_facebook_enabled', TRUE)): ?>
                        '<a id="share-facebook" onclick="shareFacebook(\'' + url + '\')"><i class="icon icm-facebook"></i></a>'+
                        <?php endif; ?>
                        <?php if (variable_get('dpr_social_share_twitter_enabled', TRUE)): ?>
                        '<a id="share-twitter" href="javascript:void(0);" onclick="shareTwitter(\'' + url + '\', \'' + title + '\' )"  ><i class="icon icm-twitter"></i></a>'+
                        <?php endif; ?>
                        <?php if (variable_get('dpr_social_share_google_enabled', TRUE)): ?>
                        '<a id="share-googleplus" href="javascript:void(0)" onclick="shareGoogleplus(\'' + url + '\')"><i class="icon icm-googleplus"></i></a>'+
                        <?php endif; ?>
                        <?php if (variable_get('dpr_social_share_instagram_enabled', TRUE)): ?>
                        '<a id="share-instagram" href="javascript:void(0)" onclick="shareInstagram()"><i class="icon icm-instagram"></i></a>'+
                        <?php endif; ?>
                        '</div>';
                
                var self = this;
                $(this).popover({
                    trigger : 'manual',  
                    placement : 'bottom', 
                    html: 'true',
                    content: content,
                    template : '<div class="socialmedia-popover <?= $popover_width ?> bottom"><div class="arrow"></div><div class="popover-content">' +
                            '</div></div>'
                 });


               
                $(this).popover("show");
                $(".socialmedia-popover").on("mouseleave", function(){
                    $(self).popover("hide");
                });
            })
            .on("mouseleave", function(){
                var self = this;
                setTimeout(function () {
                    if (!$(".socialmedia-popover:hover").length) {
                        $(self).popover("hide");
                    }
                }, 300);
            });
        });
    }(jQuery));


    (function(d, s, id) {
                   var js, fjs = d.getElementsByTagName(s)[0];
                   if (d.getElementById(id)) return;
                   js = d.createElement(s); js.id = id;
                   js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                   fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));


    shareFacebook = function(url) {
        // A function to share current content on Facebook.
        FB.init({
            appId      : '<?= $facebookAppId ?>',
            status     : true,
            xfbml      : true,
            version    : 'v2.7' // or v2.6, v2.5, v2.4, v2.3
        });

        FB.ui({
            method: 'share_open_graph',
            action_type: 'og.likes',
            action_properties: JSON.stringify({
                object: url,
            })
        }, function(response){});
    };

    shareTwitter = function(url, title) {
        var text = "text=" + title;
        var url = "&url="+url;
        var twitter = "https://twitter.com/intent/tweet?";
        var fullPath = twitter + text +  url;
        // A function to share current content on Twitter.
        window.open(fullPath,"","width=550,height=200");
    };

    shareGoogleplus = function(url){
        // A function to share current content on Google Plus.
        var url = "https://plus.google.com/share?url=" + url;
        window.open(url, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");
    };
    
    shareInstagram = function(){
        var instagramPath = '<?= $instagramUrl ?>';
        if(instagramPath !== '') {
            window.open(instagramPath);
        }
    }

</script>

<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>

