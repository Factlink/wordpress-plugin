<div class='wrap'>

    <h2>Factlink settings</h2>

    <form method='post' action='options.php'>

        <?php

            // configures hidden fields
            settings_fields( 'factlink_option_group' );
        ?>
        <?php

            // prints settings
            do_settings_sections( 'factlink_option_group' );
        ?>

        <label for="<?php echo $this->settings->option_1->name(true); ?>"><?php echo $this->settings->option_1->name(true); ?></label>
        <input type="text" name="<?php echo $this->settings->option_1->name(true); ?>" value="<?php echo $this->settings->option_1->get(); ?>">

        <?php submit_button(); ?>

    </form>

</div>