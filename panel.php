<?php
        add_action( 'admin_menu', 'include_plugin_menu' );
	function include_plugin_menu() {
		add_submenu_page( "tools.php", "Include", "Include", "manage_options", "include-plugin", "include_plugin_options");
	}
	function include_plugin_options() {
		if ( !current_user_can( 'manage_options' ) )  { wp_die( __( 'You do not have sufficient permissions to access this page.' ) ); }

		if($_POST["include_form_submit"] == "y"){
			// Process the form info here
			if(include_set_options($_POST['include_options'])) echo "<div class='updated'><p>Updated Successfully</p></div>";
		}
		$options = include_get_options();

                /* Array for recursion options */
                $recursion_types = array("strict", "weak");

                /* Array for option descriptions */
                $option_tips = array (
                    'title' => 'The type of element to wrap the title with.',
                    'title_class' => 'A class to assign to the title wrap.',
                    'recursion' => 'Strict will not run the shortcode on included child pages.',
                    'hr' => 'Set to anything other than blank to insert a horizontal rule before included content.',
                    'wrap' => 'Element to wrap included content with.',
                    'wrap_class' => 'A class to assign to the wrap.'
                );
		?>
			<div class="wrap">
                            <h2>Include Options</h2>
				<form action="" method="post">
					<input type='hidden' name='include_form_submit' value='y'>
					<table class="form-table">
						<tbody>
							<?php foreach($options as $optname => $optvalue) {
                                                            if ($optname == "recursion") { ?>
                                                                <tr><th><label for="<?=$optname ?>"><?=ucwords(strtolower(str_replace('_', ' ', $optname))) ?></label></th><td><select name="include_options[<?=$optname ?>]" style="width:350px;">
                                                                <?php
                                                                foreach ($recursion_types as $recursion_type) {?>
                                                                    <option value="<?=$recursion_type ?>" id="<?=$recursion_type ?>" <?php if ($recursion_type == $optvalue) { ?> selected <?php } ?>><?=$recursion_type ?></option>
                                                            <?php } ?>
                                                                </select><p class="description"><?=$option_tips['recursion'] ?></p>
                                                                </td></tr>
                                                            <?php }
                                                            else if($optvalue !== false) {  ?>
                                                                 <tr><th><label for="<?=$optname ?>"><?=ucwords(strtolower(str_replace('_', ' ', $optname))) ?></label></th><td><input type="text" name="include_options[<?=$optname ?>]" id="<?=$optname ?>" class="regular-text code" value="<?=$optvalue ?>">
                                                                 <p class="description"><?=$option_tips[$optname] ?></p></td></tr>
                                                        <?php } } ?>
                                                                <tr><th></th><td><input type="submit" value="Save Changes" class="button button-primary"></td></tr>
                                                </tbody>
					</table>
				</form>
			</div>
		<?php
	}