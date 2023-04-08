<?php

add_action("init", function () {
    add_shortcode("MusicPlayerAFB", "afbMusicPlayerShortcode");
});



function afbMusicPlayerShortcode($args)
{

    $afb_atts = shortcode_atts(
        array(
            'id' => '',
			"curr_id"=>""
        ),
        $args
    );

    return getHtmlAFB($afb_atts);
}



function getHtmlAFB($afb_atts)
{
    ob_start();
    include AFB_MUSIC_PATH ."public/player/player_template.php";
    $content = ob_get_clean();

    return $content;

}
