<?php
if ($afb_atts['id'] == "") {
    echo "No ID Provided to Shortcode, Please Provide ID of the Music Player";
} else {
   	if($afb_atts['curr_id']==""){
		$afb_atts['curr_id']=0;
	}

//     $maleAudio = isset($musicData['afb_music_player_audio_male']) ? wp_get_attachment_url($musicData['afb_music_player_audio_male'][0]) : "";
//     $femaleAudio = isset($musicData['afb_music_player_audio_female']) ? wp_get_attachment_url($musicData['afb_music_player_audio_female'][0]) : "";
	
	$audio= get_post_meta( $afb_atts['id'] , "audios", true );
	
	if(array_key_exists( 'item-'.$afb_atts['curr_id'] ,$audio)){
		$musicData= $audio['item-'.$afb_atts['curr_id']];
	}else{
		$musicData= $audio['item-0'];
		$reset=true;
	}
	

	$maleAudio= $musicData['afb_music_player_audio_male'];
	$femaleAudio= $musicData['afb_music_player_audio_female'];
	
// 	echo "<pre>";
// 	print_r( $musicData );
// 	echo "</pre>";
// 	exit;
?>
<style>
	.afb_player_div{
		display:none
	}
</style>
<div class="afb_player_div">
	
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href='<?php echo plugin_dir_url(__FILE__) . "style.css"; ?>' />



    <div class="hero post_<?php echo $afb_atts['id']; ?>">
        <img style="display: none !important" src='<?php echo plugin_dir_url(__FILE__) . "media/pause.png"; ?>' alt="">
        <div class="music">
            <div class="form-box">
                <div class="button-box audio_<?php echo $afb_atts['id']; ?>">
                    <div id="btn" class="btnc btn_<?php echo $afb_atts['id']; ?>"></div>
                    <?php
                    if ($maleAudio != "") {
                    ?>
                        <a type="button" class="toggle-btn" onclick="leftClick<?php echo $afb_atts['id']; ?>('<?php echo $afb_atts['id']; ?>')">
                            <img class="avatarx" src="<?php echo plugin_dir_url(__FILE__) . 'media/male.png' ?>" width="150px" alt="">
                        </a>
                    <?php
                    } ?>

                    <?php
                    if ($femaleAudio != "") {
                    ?>
                        <a type="button" class="toggle-btn" onclick="rightClick<?php echo $afb_atts['id']; ?>('<?php echo $afb_atts['id']; ?>')">
                            <img class="avatarx" src="<?php echo plugin_dir_url(__FILE__) . 'media/female.png' ?>" width="150px" alt="">
                        </a>
                    <?php
                    } ?>
                </div>
            </div>
            <!-- <p>Artist: NEFFEX</p> -->
            <h2 class="custom_above_text"> <?php echo $musicData['afb_music_player_custom_above_text']; ?> </h2>
            <div class="track">
                <img width="40px" class="desktop_ playbtn_<?php echo $afb_atts['id']; ?>" src='<?php echo plugin_dir_url(__FILE__) . "media/play.png"; ?>' alt="" id="playBtn" />
                <div id="waveform_male_<?php echo $afb_atts['id']; ?>"></div>
                <div id="waveform_female_<?php echo $afb_atts['id']; ?>"></div>
                <span class="player_img_div">
                    <img class="player_img repeat_btn_player" onclick="repeatBtnToggle<?php echo $afb_atts['id']; ?>(event)" src="<?php echo plugin_dir_url(__FILE__) . "media/repeat.png"; ?>" />

                    <img class="mobile_ playbtn_<?php echo $afb_atts['id']; ?>" src='<?php echo plugin_dir_url(__FILE__) . "media/play.png"; ?>' alt="" id="playBtn" />

                    <span class="speeds_div speeds_div_<?php echo $afb_atts['id']; ?>"  onmouseover="showSpeeds<?php echo $afb_atts['id']; ?>()" ontouchstart="showSpeeds<?php echo $afb_atts['id']; ?>()" onmouseleave="hideSpeeds<?php echo $afb_atts['id']; ?>()" ontouchcancel="hideSpeeds<?php echo $afb_atts['id']; ?>()">
                        <span data-speed='0.5' onclick="toggleSpeedX<?php echo $afb_atts['id']; ?>(event,0.5)">0.5x</span>
                        <img class="player_img" onclick="toggleSpeedX<?php echo $afb_atts['id']; ?>(event,1)" src="<?php echo plugin_dir_url(__FILE__) . "media/1x.png"; ?>" alt="">
                        <span data-speed='1.5' onclick="toggleSpeedX<?php echo $afb_atts['id']; ?>(event,1.5)">1.5x</span>
                    </span>
                </span>
            </div>
            <h2 class="custom_below_text"><?php echo $musicData['afb_music_player_custom_below_text']; ?> </h2>

            <div class="character_div">
                <h6>Character:
                    <span class=""><?php echo isset($musicData['afb_music_player_character']) ? $musicData['afb_music_player_character'] : ""; ?></span>
                </h6>

                <div class="button-box audio_<?php echo $afb_atts['id']; ?>">
                    <div id="btn" class="btnc btn_<?php echo $afb_atts['id']; ?>"></div>
                    <?php
                    if ($maleAudio != "") {
                    ?>
                        <a type="button" class="toggle-btn" onclick="leftClick<?php echo $afb_atts['id']; ?>('<?php echo $afb_atts['id']; ?>')">
                            <img class="avatarx" src="<?php echo plugin_dir_url(__FILE__) . 'media/male.png' ?>" width="150px" alt="">
                        </a>
                    <?php
                    } ?>

                    <?php
                    if ($femaleAudio != "") {
                    ?>
                        <a type="button" class="toggle-btn" onclick="rightClick<?php echo $afb_atts['id']; ?>('<?php echo $afb_atts['id']; ?>')">
                            <img class="avatarx" src="<?php echo plugin_dir_url(__FILE__) . 'media/female.png' ?>" width="150px" alt="">
                        </a>
                    <?php
                    } ?>
                </div>
            </div>
        </div>



    </div>


    <?php
	
	
//     add_action('wp_footer', function() use ( $afb_atts, $maleAudio , $femaleAudio ) { 
       
    ?>


<!-- AUDIO ID :    <?php echo $afb_atts['id'] ?> -->

        <script src="https://unpkg.com/wavesurfer.js"></script>
        <script src='<?php echo plugin_dir_url(__FILE__) . "script.js"; ?>'></script>

        <script>
            if (screen.width < 560) {
                document.querySelector(".character_div .button-box.audio_<?php echo $afb_atts['id']; ?>").remove()
                document.querySelector(".post_<?php echo $afb_atts['id']; ?> .desktop_").remove()
            } else {
                document.querySelector(".form-box .button-box.audio_<?php echo $afb_atts['id']; ?>").remove()
                document.querySelector(".post_<?php echo $afb_atts['id']; ?> .mobile_").remove()
            }


            var wavesurfer_<?php echo $afb_atts['id']; ?>;
            var repeatYes_<?php echo $afb_atts['id']; ?> = false;
            var oneXYes_<?php echo $afb_atts['id']; ?> = 1

            function malePlayer<?php echo $afb_atts['id']; ?>() {
                <?php
                if ($maleAudio != "") {

                ?>
                    buildPlayer<?php echo $afb_atts['id']; ?>("male", '<?php echo $maleAudio; ?>');
                    console.log("<?php echo $afb_atts['id']; ?>", " male ", " <?php echo $maleAudio; ?> ")
                    document.getElementById("waveform_male_<?php echo $afb_atts['id']; ?>").style.display = "block";
                    document.getElementById("waveform_female_<?php echo $afb_atts['id']; ?>").style.display = "none";

                <?php
                } elseif ($femaleAudio != "") {
                ?>
                    console.log("<?php echo $afb_atts['id']; ?>", " female ", " <?php echo $maleAudio; ?> ")
                    buildPlayer<?php echo $afb_atts['id']; ?>("female", '<?php echo $maleAudio; ?>');
                    document.getElementById("waveform_male_<?php echo $afb_atts['id']; ?>").style.display = "none";
                    document.getElementById("waveform_female_<?php echo $afb_atts['id']; ?>").style.display = "block";
                <?php
                } else {
                    echo "alert('No Audios In this Player')";
                    
                }
                ?>
            }

            //var btn = document.querySelector('#btn.btn_<?php echo $afb_atts['id']; ?>')

            function leftClick<?php echo $afb_atts['id']; ?>($id) {
                var btn = document.querySelector('#btn.btn_<?php echo $afb_atts['id']; ?>')
                console.log("btn.style.left,  ", btn)
                if (btn.style.left != '0px') {

                    wavesurfer_<?php echo $afb_atts['id']; ?>.destroy();

                    buildPlayer<?php echo $afb_atts['id']; ?>("male", '<?php echo $maleAudio; ?>')
                    document.getElementById("waveform_male_<?php echo $afb_atts['id']; ?>").style.display = "block";
                    document.getElementById("waveform_female_<?php echo $afb_atts['id']; ?>").style.display = "none";

                    let playBtn = document.querySelector("#playBtn.playbtn_<?php echo $afb_atts['id']; ?>");
                    playBtn.src = '<?php echo plugin_dir_url(__FILE__) . "media/play.png"; ?>';
                }

                btn.style.left = '0'
            }

            function rightClick<?php echo $afb_atts['id']; ?>($id) {
                var btn = document.querySelector('#btn.btn_<?php echo $afb_atts['id']; ?>')
                if (btn.style.left != '50px') {

                    wavesurfer_<?php echo $afb_atts['id']; ?>.destroy();

                    buildPlayer<?php echo $afb_atts['id']; ?>("female", '<?php echo $femaleAudio; ?>')
                    document.getElementById("waveform_male_<?php echo $afb_atts['id']; ?>").style.display = "none";
                    document.getElementById("waveform_female_<?php echo $afb_atts['id']; ?>").style.display = "block";

                    let playBtn = document.querySelector("#playBtn.playbtn_<?php echo $afb_atts['id']; ?>");
                    playBtn.src = '<?php echo plugin_dir_url(__FILE__) . "media/play.png"; ?>';
                }


                btn.style.left = '50px'
            }




            function repeatBtnToggle<?php echo $afb_atts['id']; ?>(event) {

                if (repeatYes_<?php echo $afb_atts['id']; ?>) {
                    wavesurfer_<?php echo $afb_atts['id']; ?>.un("finish")
                    repeatYes_<?php echo $afb_atts['id']; ?> = false
                    addFinishTasks<?php echo $afb_atts['id']; ?>()
                    event.target.style.boxShadow = "none"

                } else {
                    wavesurfer_<?php echo $afb_atts['id']; ?>.on("finish", function() {
                        wavesurfer_<?php echo $afb_atts['id']; ?>.play()
                    })

                    event.target.style.boxShadow = "#30aeaa 0px 0px 2px 4px"
                    repeatYes_<?php echo $afb_atts['id']; ?> = true
                }

            }


            function toggleSpeedX<?php echo $afb_atts['id']; ?>(event, speed) {
                if (oneXYes_<?php echo $afb_atts['id']; ?> == speed) {
                    return false
                }
                // if(speed != 1){
                //     console.log("yeah ", event.target)
                //     event.target.style.display="block"
                // }
                wavesurfer_<?php echo $afb_atts['id']; ?>.setPlaybackRate(speed)
                oneXYes_<?php echo $afb_atts['id']; ?> = speed
                hideSpeeds<?php echo $afb_atts['id']; ?>()
            }

            function showSpeeds<?php echo $afb_atts['id']; ?>() {
                var spansX = document.querySelectorAll(".post_<?php echo $afb_atts['id']; ?> .speeds_div_<?php echo $afb_atts['id']; ?> > span")

                spansX.forEach(function(ele) {
                    ele.style.display = "block"
                })

                document.querySelector(".post_<?php echo $afb_atts['id']; ?> .speeds_div_<?php echo $afb_atts['id']; ?>").classList.add("bg_purple")
                document.querySelector(".post_<?php echo $afb_atts['id']; ?> .speeds_div_<?php echo $afb_atts['id']; ?> .player_img").style.display = "block"
            }

            function hideSpeeds<?php echo $afb_atts['id']; ?>() {
                var spansX = document.querySelectorAll(".post_<?php echo $afb_atts['id']; ?> .speeds_div_<?php echo $afb_atts['id']; ?> > span")

                spansX.forEach(function(ele) {
                    var spd = ele.getAttribute("data-speed")

                    if (spd != 1 && spd == oneXYes_<?php echo $afb_atts['id']; ?>.toString()) {
                        ele.style.display = "block"
                        // document.querySelector(".speeds_div").style.borderRadius="50%"
                        document.querySelector(".post_<?php echo $afb_atts['id']; ?> .speeds_div_<?php echo $afb_atts['id']; ?> .player_img").style.display = "none"
                    } else if (oneXYes_<?php echo $afb_atts['id']; ?> == 1) {

                        ele.style.border = "0px"
                        ele.style.display = "none"
                        // document.querySelector(".speeds_div").style.borderRadius="25px"
                        document.querySelector(".post_<?php echo $afb_atts['id']; ?> .speeds_div_<?php echo $afb_atts['id']; ?> .player_img").style.display = "block"

                    } else {
                        ele.style.display = "none"
                    }

                    if (spd == "1") {
                        document.querySelector(".post_<?php echo $afb_atts['id']; ?> .speeds_div_<?php echo $afb_atts['id']; ?>").classList.remove("bg_purple")
                    }

                })


            }



            function addFinishTasks<?php echo $afb_atts['id']; ?>() {
                wavesurfer_<?php echo $afb_atts['id']; ?>.on("finish", function() {

                    if (!repeatYes_<?php echo $afb_atts['id']; ?>) {
                        playBtn.src = '<?php echo plugin_dir_url(__FILE__) . "media/play.png"; ?>';
                    }

                    wavesurfer_<?php echo $afb_atts['id']; ?>.stop();
                });
            }



            function buildPlayer<?php echo $afb_atts['id']; ?>($type, $audio) {
                console.log("building player ", $type, "<?php echo $afb_atts['id']; ?>")
                var playBtn = document.querySelector("#playBtn.playbtn_<?php echo $afb_atts['id']; ?>");

                wavesurfer_<?php echo $afb_atts['id']; ?> = WaveSurfer.create({
                    container: "#waveform_" + $type + "_<?php echo $afb_atts['id']; ?>",
                    waveColor: "#ddd",
                    progressColor: "orange",
                    barWidth: 5,
                    responsive: true,
                    height: 77,
                    barRadius: 4,
                    autoCenter: true,
                    fillParent: true,
                    mediaControls: true,
                    // barGap:170
                });

                wavesurfer_<?php echo $afb_atts['id']; ?>.load($audio);

                playBtn.onclick = function() {
                    wavesurfer_<?php echo $afb_atts['id']; ?>.playPause();

                    if (playBtn.src.includes("play.png")) {
                        playBtn.src = '<?php echo plugin_dir_url(__FILE__) . "media/pause.png"; ?>';
                    } else {
                        playBtn.src = '<?php echo plugin_dir_url(__FILE__) . "media/play.png"; ?>';
                    }
                };


                addFinishTasks<?php echo $afb_atts['id']; ?>()

            }
        </script>

        <script>
            jQuery(function($) {
				
				$(".afb_player_div").ready(function(){
					$(".afb_player_div").css("display","block")
				})

                $(window).resize(stablePlayer<?php echo $afb_atts['id']; ?>)

                const width = $(window).width()
                stablePlayer<?php echo $afb_atts['id']; ?>()
                malePlayer<?php echo $afb_atts['id']; ?>()

                function stablePlayer<?php echo $afb_atts['id']; ?>() {

                    if (width < 560) {
                        // $(".character_div .button-box")[0].remove()
                        const playBtn = $("#playBtn")
                        const waveFormFemale = $("#waveform_female")
                        const waveFormMale = $("#waveform_male")

                        // $("#waveform_female").after(playBtn);

                        waveFormMale.css({
                            "flex-shrink": "0",
                            "flex-grow": "0",
                            "flex-basis": "100%"
                        })

                        waveFormFemale.css({
                            "flex-shrink": "0",
                            "flex-grow": "0",
                            "flex-basis": "100%"
                        })
                    } else {
                        // $(".form-box .button-box")[0].remove()
                    }
                }
            })
        </script>
	
</div>
<?php
//     }
//     , 1000);
}
