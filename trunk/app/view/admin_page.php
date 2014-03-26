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

        <input type="hidden" name="<?php echo $this->settings->enabled_for_posts->name(); ?>" value="0">
        <input type="checkbox" name="<?php echo $this->settings->enabled_for_posts->name(); ?>" <?php if ($this->settings->enabled_for_posts->get() == 1){ echo 'checked'; } ?> id="<?php echo $this->settings->enabled_for_posts->name(); ?>" value="1">
        <label for="<?php echo $this->settings->enabled_for_posts->name(); ?>">Enabled for posts</label>

        <br />

        <input type="hidden" name="<?php echo $this->settings->enabled_for_pages->name(); ?>" value="0">
        <input type="checkbox" name="<?php echo $this->settings->enabled_for_pages->name(); ?>" <?php if ($this->settings->enabled_for_pages->get() == 1){ echo 'checked'; } ?> id="<?php echo $this->settings->enabled_for_pages->name(); ?>" value="1">
        <label for="<?php echo $this->settings->enabled_for_pages->name(); ?>">Enabled for pages</label>

        <br />

        <input type="hidden" name="<?php echo $this->settings->disable_global_comments->name(); ?>" value="0">
        <input type="checkbox" name="<?php echo $this->settings->disable_global_comments->name(); ?>" <?php if ($this->settings->disable_global_comments->get() == 1){ echo 'checked'; } ?> id="<?php echo $this->settings->disable_global_comments->name(); ?>" value="1">
        <label for="<?php echo $this->settings->disable_global_comments->name(); ?>">Totally replace wordpress comments with Factlink</label>

        <?php submit_button(); ?>

    </form>

</div>