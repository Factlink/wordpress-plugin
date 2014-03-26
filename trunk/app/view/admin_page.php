<div class='wrap'>

    <h2>Factlink settings</h2>

    <form method='post' action='options.php'>

        <?php

            // configures hidden fields
            settings_fields( $this->option_group );
        ?>
        <?php

            // prints settings
            do_settings_sections( $this->option_group );
        ?>



        <input type="hidden" name="<?php echo $this->settings->enabled_for_posts->name(true); ?>" value="0">
        <input type="checkbox" name="<?php echo $this->settings->enabled_for_posts->name(true); ?>" <?php if ($this->settings->enabled_for_posts->get() == 1){ echo 'checked'; } ?> id="<?php echo $this->settings->enabled_for_posts->name(true); ?>" value="1">
        <label for="<?php echo $this->settings->enabled_for_posts->name(true); ?>">Enabled for posts</label>

        <br />


        <input type="hidden" name="<?php echo $this->settings->enabled_for_pages->name(true); ?>" value="0">
        <input type="checkbox" name="<?php echo $this->settings->enabled_for_pages->name(true); ?>" <?php if ($this->settings->enabled_for_pages->get() == 1){ echo 'checked'; } ?> id="<?php echo $this->settings->enabled_for_pages->name(true); ?>" value="1">
        <label for="<?php echo $this->settings->enabled_for_pages->name(true); ?>">Enabled for pages</label>

        <?php submit_button(); ?>

    </form>

</div>