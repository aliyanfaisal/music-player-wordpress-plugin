<?php


class MusicPlayerPostType
{


    function __construct()
    {
        add_action('init',      array($this, 'addPostTppe'));
        add_action('add_meta_boxes', array($this, 'addMetaBoxes'));
        add_action("save_post",  array($this, "save"));
        add_action('add_meta_boxes', array($this, 'remove_metaboxes'));
    }


    public function addPostTppe()
    {
	
		add_action( 'init', function () {
  


		});

		
		
		
		
		
        // Set UI labels for Custom Post Type
        $labels = array(
            'name'                => __('Music Players Lessons', 'Post Type General Name', 'twentytwentyone'),
            'singular_name'       => __('MusicPlayer Lesson', 'Post Type Singular Name', 'twentytwentyone'),
            'menu_name'           => __('Music Player lessons', 'twentytwentyone'),
            'parent_item_colon'   => __('Parent MusicPlayer', 'twentytwentyone'),
            'all_items'           => __('All MusicPlayer lessons', 'twentytwentyone'),
            'view_item'           => __('View MusicPlayer lesson', 'twentytwentyone'),
            'add_new_item'        => __('Add New MusicPlayer lesson', 'twentytwentyone'),
            'add_new'             => __('Add New', 'twentytwentyone'),
            'edit_item'           => __('Edit MusicPlayer lesson', 'twentytwentyone'),
            'update_item'         => __('Update MusicPlayer lesson', 'twentytwentyone'),
            'search_items'        => __('Search MusicPlayer lesson', 'twentytwentyone'),
            'not_found'           => __('Not Found', 'twentytwentyone'),
            'not_found_in_trash'  => __('Not found in Trash', 'twentytwentyone'),
        );

        // Set other options for Custom Post Type

        $args = array(
            'label'               => __('Music Player Lessons', 'twentytwentyone'),
            'description'         => __('Add Music Player Lesson from here', 'twentytwentyone'),
            'labels'              => $labels,
            // Features this CPT supports in Post Editor
            'supports'            => array('title', 'author', 'thumbnail', "excerpt"),
            // You can associate this CPT with a taxonomy or custom taxonomy. 
            'taxonomies'          => array('subjects'),
            /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
            'show_in_rest' => true,
            "menu_icon" => "dashicons-media-audio"


        );

        register_post_type('Lessons', $args);
		
		
		
				// Add new taxonomy, make it hierarchical like categories
		//first do the translations part for GUI

		  $labels = array(
			'name' => _x( 'Course Language', 'taxonomy general name' ),
			'singular_name' => _x( 'Course Language', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Course Languages' ),
			'all_items' => __( 'All Course Languages' ),
			'parent_item' => __( 'Parent Course Language' ),
			'parent_item_colon' => __( 'Parent Course Language:' ),
			'edit_item' => __( 'Edit Course Language' ), 
			'update_item' => __( 'Update Course Language' ),
			'add_new_item' => __( 'Add New Course Language' ),
			'new_item_name' => __( 'New Course Language Name' ),
			'menu_name' => __( 'Course Language' ),
		  );    
 
		// Now register the taxonomy
		  register_taxonomy('courselanguage',array('lessons'), array(
				'hierarchical' => true,
				'labels' => $labels,
				'show_ui' => true,
				'show_in_rest' => true,
				'show_admin_column' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'courselanguage' ),
			  ));
    }


    public function save($post_id)
    {

        // Check if our nonce is set.
        if (!isset($_POST['afb_music_player_nonce'])) {
            return $post_id;
        }

        $nonce = $_POST['afb_music_player_nonce'];

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, 'afb_music_player')) {
            return $post_id;
        }

        /*
		 * If this is an autosave, our form has not been submitted,
		 * so we don't want to do anything.
		 */
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        // Check the user's permissions.
        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } else {
            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }
        }

        /* OK, it's safe for us to save the data now. */
        $inputs = $_POST;
        unset($inputs['wp_nonce']);
        // Sanitize the user input.
        foreach ($inputs as $key => $value) {
            $inputs[$key] = sanitize_text_field($value);
        }


        // Update the meta field.
        update_post_meta($post_id, "afb_music_player_audio_male", $inputs["afb_music_player_audio_male"]);

        update_post_meta($post_id, "afb_music_player_audio_female", $inputs["afb_music_player_audio_female"]);

        update_post_meta($post_id, "afb_music_player_custom_below_text", $inputs["afb_music_player_custom_below_text"]);

        update_post_meta($post_id, "afb_music_player_custom_above_text", $inputs["afb_music_player_custom_above_text"]);

        update_post_meta($post_id, "afb_music_player_character", $inputs["afb_music_player_character"]);


        if (isset($_POST['musicplayer_next_id'])) {
            update_post_meta($post_id, "musicplayer_next_id", $inputs["musicplayer_next_id"]);
        }

        function sample_admin_notice__success()
        {
?>
            <div class="notice notice-success is-dismissible">
                <p><?php _e('Well Done!... Use the Shortcode below to show Player', 'sample-text-domain'); ?></p>
            </div>
        <?php
        }
        add_action('admin_notices', 'sample_admin_notice__success');
    }

    public function addMetaBoxes()
    {
        add_meta_box(
            'afb-music-player-shortcode',
            __('Shortcode', 'shortcode'),
            array($this, "showShortcode"),
            'lessons',
            "normal",
            "high"
        );

//         add_meta_box(
//             'afb-music-player',
//             __('Add Details', 'audios'),
//             array($this, "audiosBox"),
//             'musicplayer',
//             "normal",
//             "high"
//         );

//         add_meta_box(
//             'afb-music-player-next-audio',
//             __('Select Next', 'audios'),
//             array($this, "select_box"),
//             'musicplayer',
//             "side",
//             "high"
//         );
    }


    public function showShortcode($post)
    {

        ?>
        <div>
            <strong>Shortcode:</strong>
            <div style="background-color: #446EE7;color:white;padding:5px 10px; display:inline-block">[MusicPlayerAFB id="<?php echo $post->ID; ?>"]</div>
        </div>

    <?php
    }
    public function remove_metaboxes()
    {
        // remove_meta_box( 'postcustom' , 'page' , 'normal' ); //removes custom fields for page
        // remove_meta_box( 'commentstatusdiv' , 'page' , 'normal' ); //removes comments status for page
        // remove_meta_box( 'commentsdiv' , 'page' , 'normal' ); //removes comments for page
        // remove_meta_box( 'authordiv' , 'page' , 'normal' ); //removes author for page
    }

    public  function select_box($post)
    {
        $selected_post_id = get_post_meta($post->ID, 'musicplayer_next_id', true);
        global $wp_post_types;
        $save_hierarchical = $wp_post_types["lessons"]->hierarchical;
        $wp_post_types["lessons"]->hierarchical = true;
        wp_dropdown_pages(array(
            'id' => "_musicplayer_next_id",
            'name' => "musicplayer_next_id",
            'selected' => empty($selected_post_id) ? 0 : $selected_post_id,
            'post_type' => 'lessons',
            'show_option_none' => "Next Audio",
        ));
        $wp_post_types['lessons']->hierarchical = $save_hierarchical;
    }

    public function audiosBox($post)
    {
        remove_meta_box('postcustom', 'lessons', 'normal');
        wp_enqueue_media();
        // Add an nonce field so we can check for it later.
        wp_nonce_field('afb_music_player', 'afb_music_player_nonce');

        // Use get_post_meta to retrieve an existing value from the database.
        $metaData = get_post_meta($post->ID,"audios",true);

        echo "<pre>";
        print_r( ( $metaData ));
        echo "</pre>";
//         Display the form, using the current value.
    ?>
        <style>
            .row_ {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                margin-top: 20px;
            }

            .myLabels {
                margin-bottom: 8px;
            }

            .afbBtns {
                padding: 8px 10px;
                background-color: #478CC4;
                border-radius: 8px;
                margin-top: 10px;
                color: white
            }

            .music_player {
                display: flex;
                justify-content: center;
                flex-grow: 1;
            }

            input[type="text"] {
                width: 100%;
            }

            .full {
                flex-grow: 1;
                margin-right: 20px;
            }

            .full input {
                height: 40px;
                margin-bottom: 0px;
            }
        </style>
        <div class="row_">
            <div>
                <label for="afb_music_player_audio_1" class="myLabels">
                    <strong>
                        <?php _e('Add Male Audio', 'textdomain'); ?>
                    </strong>
                </label><br>

                <input class="afbBtns" type="button" id="afb_music_player_audio_1" name="afb_music_player_audio_1" value="Select Male Audio" />
                <input type="hidden" id="value_afb_music_player_audio_1" name="afb_music_player_audio_male" value="<?php echo $male_audio_id = isset($metaData['afb_music_player_audio_male'][0]) ?  $metaData['afb_music_player_audio_male'][0] : "";   ?>">
            </div>
            <div class="music_player" id="player_afb_music_player_audio_1">
                <?php
                if ($male_audio_id != "") {
                    $url_male = wp_get_attachment_url($male_audio_id);
                ?>


                    <audio controls>
                        <source id="audo-preview" src="<?php echo $url_male; ?>" type="audio/ogg">
                        Your browser does not support the audio element.`)
                    </audio>

                <?php
                }

                ?>
            </div>
        </div>

        <hr>

        <div class="row_">
            <div>
                <label for="afb_music_player_audio_2" class="myLabels">
                    <strong>
                        <?php _e('Add Female Audio', 'textdomain'); ?>
                    </strong>
                </label><br>

                <input class="afbBtns" type="button" id="afb_music_player_audio_2" name="afb_music_player_audio_2" value="Select Female Audio" />
                <input type="hidden" id="value_afb_music_player_audio_2" name="afb_music_player_audio_female" value="<?php echo  $female_audio_id = isset($metaData['afb_music_player_audio_female'][0]) ?  $metaData['afb_music_player_audio_female'][0] : "";   ?>">


            </div>
            <div class="music_player" id="player_afb_music_player_audio_2">
                <?php
                if ($female_audio_id != "") {
                    $url_female = wp_get_attachment_url($female_audio_id);
                ?>


                    <audio controls>
                        <source id="audo-preview" src="<?php echo $url_female; ?>" type="audio/ogg">
                        Your browser does not support the audio element.`)
                    </audio>

                <?php
                }

                ?>
            </div>
        </div>


        <hr>

        <div class="row_">
            <div class="full">
                <label for="afb_music_player_custom_above_text" class="myLabels">
                    <strong>
                        <?php _e('Add Above Custom Text', 'textdomain'); ?>
                    </strong>
                </label><br>
                <input required type="text" placeholder="Some Text" id="afb_music_player_custom_above_text" name="afb_music_player_custom_above_text" value="<?php echo  $female_audio_id = isset($metaData['afb_music_player_custom_above_text'][0]) ?  $metaData['afb_music_player_custom_above_text'][0] : "";   ?>">
                <p>Shown above the player</p>
            </div>


            <div class="full">
                <label for="afb_music_player_custom_below_text" class="myLabels">
                    <strong>
                        <?php _e('Add Below Custom Text', 'textdomain'); ?>
                    </strong>
                </label><br>
                <input required type="text" placeholder="Some Text" id="afb_music_player_custom_below_text" name="afb_music_player_custom_below_text" value="<?php echo  $female_audio_id = isset($metaData['afb_music_player_custom_below_text'][0]) ?  $metaData['afb_music_player_custom_below_text'][0] : "";   ?>">
                <p>Shown below the player</p>
            </div>
        </div>


        <div class="">
            <label for="afb_music_player_character" class="myLabels">
                <strong>
                    <?php _e('Add Character', 'textdomain'); ?>
                </strong>
            </label><br>
            <input type="text" placeholder="Character" id="afb_music_player_character" name="afb_music_player_character" value="<?php echo  $female_audio_id = isset($metaData['afb_music_player_character'][0]) ?  $metaData['afb_music_player_character'][0] : "";   ?>">
            <p>Shown below the player</p>
        </div>




    <?php



        add_action('admin_footer', array($this, "addJsFiles"));
    }



    public function addJsFiles()
    {

        $my_saved_attachment_post_id = get_option('media_selector_attachment_id', 0);

    ?><script type='text/javascript'>
            var current_id = "";
            jQuery(document).ready(function($) {

                // Uploading files
                var file_frame;
                var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
                var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>; // Set this

                jQuery('.afbBtns').on('click', function(event) {

                    event.preventDefault();
                    const target = event.target
                    current_id = target.getAttribute("id")
                    console.log("cueeeeernt", current_id)
                    // If the media frame already exists, reopen it.
                    if (file_frame) {
                        // Set the post ID to what we want
                        file_frame.uploader.uploader.param('post_id', set_to_post_id);
                        // Open frame
                        file_frame.open();
                        return;
                    } else {
                        // Set the wp.media post id so the uploader grabs the ID we want when initialised
                        wp.media.model.settings.post.id = set_to_post_id;
                    }

                    // Create the media frame.
                    file_frame = wp.media.frames.file_frame = wp.media({
                        title: 'Select an Audio to upload',
                        button: {
                            text: 'Use this Audio',
                        },
                        multiple: false // Set to true to allow multiple files to be selected
                    });

                    // When an image is selected, run a callback.
                    file_frame.on('select', function() {
                        // We set multiple to false so only get one image from the uploader
                        attachment = file_frame.state().get('selection').first().toJSON();

                        // Do something with attachment.id and/or attachment.url here
                        $('#value_' + current_id).val(attachment.id);

                        var audio = $("<audio></audio>");
                        audio.attr("controls", true).attr("id", "audio_player" + current_id)
                        audio.html(`
                                <source id="audo-preview" src="${attachment.url}" type="audio/ogg">
                                Your browser does not support the audio element.`)

                        console.log("yes id, ", current_id)
                        $("#player_" + current_id).html("").append(audio)

                        let male_player = document.getElementById("audio_player" + current_id)
                        male_player.play()


                        // Restore the main post ID
                        wp.media.model.settings.post.id = wp_media_post_id;
                    });

                    // Finally, open the modal
                    file_frame.open();
                });

                // Restore the main ID when the add media button is pressed
                jQuery('a.add_media').on('click', function() {
                    wp.media.model.settings.post.id = wp_media_post_id;
                });
            });
        </script><?php


                }
            }
