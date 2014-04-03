<div class='wrap'>

    <h2>Factlink settings</h2>

    <form method='post' action='options.php'>

        <?php

        // configures hidden fields
        settings_fields($this->option_group);
        ?>
        <?php

        // prints settings
        do_settings_sections($this->option_group);
        ?>

        <table class="form-table">

            <tr>
                <th scope="row">Posts</th>
                <td>
                    <fieldset>
                        <input type="hidden" name="<?php echo $this->settings->enabled_for_posts->name(); ?>" value="0">
                        <input type="checkbox"
                               name="<?php echo $this->settings->enabled_for_posts->name(); ?>"
                               id="<?php echo $this->settings->enabled_for_posts->name(); ?>"
                               value="1"
                            <?php if ($this->settings->enabled_for_posts->get() == 1) {
                                echo 'checked';
                            } ?>>
                        <label for="<?php echo $this->settings->enabled_for_posts->name(); ?>">Enabled for posts</label>

                        <br/>
                        <label>
                            <input type="radio" name="<?php echo $this->settings->enabled_for_all_posts->name(); ?>"
                                   value="1" <?php if ($this->settings->enabled_for_all_posts->get() == "1") {
                                echo "checked";
                            } ?>>
                            All posts
                        </label>
                        <br/>

                        <label>
                            <input type="radio" name="<?php echo $this->settings->enabled_for_all_posts->name(); ?>"
                                   value="0" <?php if ($this->settings->enabled_for_all_posts->get() == "0") {
                                echo "checked";
                            } ?>>
                            Selected posts
                        </label>
                    </fieldset>
                </td>
            </tr>

            <tr>
                <th scope="row">Pages</th>
                <td>
                    <fieldset>
                        <input type="hidden" name="<?php echo $this->settings->enabled_for_pages->name(); ?>" value="0">
                        <input type="checkbox"
                               name="<?php echo $this->settings->enabled_for_pages->name(); ?>"
                               id="<?php echo $this->settings->enabled_for_pages->name(); ?>"
                               value="1"
                            <?php if ($this->settings->enabled_for_pages->get() == 1) {
                                echo 'checked';
                            } ?>>
                        <label for="<?php echo $this->settings->enabled_for_pages->name(); ?>">Enabled for pages</label>

                        <br/>
                        <label>
                            <input type="radio" name="<?php echo $this->settings->enabled_for_all_pages->name(); ?>"
                                   value="1" <?php if ($this->settings->enabled_for_all_pages->get() == "1") {
                                echo "checked";
                            } ?>>
                            All pages
                        </label>
                        <br/>

                        <label>
                            <input type="radio" name="<?php echo $this->settings->enabled_for_all_pages->name(); ?>"
                                   value="0" <?php if ($this->settings->enabled_for_all_pages->get() == "0") {
                                echo "checked";
                            } ?>>
                            Selected pages
                        </label>
                    </fieldset>
                </td>
            </tr>

            <tr>
                <th scope="row">Comments</th>
                <td>
                    <fieldset>
                        <input type="hidden" name="<?php echo $this->settings->disable_global_comments->name(); ?>"
                               value="0">
                        <input type="checkbox"
                               name="<?php echo $this->settings->disable_global_comments->name(); ?>" <?php if ($this->settings->disable_global_comments->get() == 1) {
                            echo 'checked';
                        } ?> id="<?php echo $this->settings->disable_global_comments->name(); ?>" value="1">
                        <label for="<?php echo $this->settings->disable_global_comments->name(); ?>">Replace Wordpress
                            comments with Factlink comments.</label>
                    </fieldset>
                    <p class="description">Disables the Wordpress ability to add new comments, but doesn't remove the
                        existing ones.</p>
                </td>
            </tr>

        </table>

        <?php submit_button(); ?>

    </form>

</div>
