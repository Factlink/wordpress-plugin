<input type="hidden" name="<?php echo $this->meta_name; ?>" value="0">
<input type="checkbox" name="<?php echo $this->meta_name; ?>" value="1" id="<?php echo $this->meta_name; ?>" <?php if($this->meta_value == 1){ echo 'checked'; } ?>>
<label for="<?php echo $this->meta_name; ?>">Enable factlink for this item</label>
