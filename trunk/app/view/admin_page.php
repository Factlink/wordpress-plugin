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

            <?php foreach($this->is_enabled_options as $post_type => $is_enabled_option) { ?>

                <tr>
                    <th scope="row">Enable discussions on <?php echo $this->get_post_type_label($post_type) ?>:</th>
                    <td>
                        <fieldset>

                            <label>
                                <input type="radio" name="<?php echo $is_enabled_option->name(); ?>"
                                       value="2" <?php if ($is_enabled_option->get() == "2") {
                                    echo "checked";
                                } ?>>
                                All <?php echo $this->get_post_type_label($post_type) ?>
                            </label>
                            <br/>

                            <label>
                                <input type="radio" name="<?php echo $is_enabled_option->name(); ?>"
                                       value="1" <?php if ($is_enabled_option->get() == "1") {
                                    echo "checked";
                                } ?>>
                                Selected <?php echo $this->get_post_type_label($post_type) ?>
                            </label>
                            <br/>

                            <label>
                                <input type="radio" name="<?php echo $is_enabled_option->name(); ?>"
                                       value="0" <?php if ($is_enabled_option->get() == "0") {
                                    echo "checked";
                                } ?>>
                                No <?php echo $this->get_post_type_label($post_type) ?>
                            </label>
                        </fieldset>
                    </td>
                </tr>

            <?php } ?>

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
                        <label for="<?php echo $this->settings->disable_global_comments->name(); ?>">Disable the default Wordpress comments.</label>
                    </fieldset>
                    <p class="description">Note: Disables the Wordpress ability to add new comments, but still shows the existing ones.</p>
                </td>
            </tr>

        </table>

        <?php submit_button(); ?>

    </form>

</div>
