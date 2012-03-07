	<fieldset>
		<legend>Extra User Meta Stuff</legend>

			<div class="control-group">
				<label class="checkbox" for="editor">Editor</label>
				<div class="controls">
					<label>
						<input type="checkbox" name="editor" id="editor" value="1">
						Editor
					</label>
				</div>
			</div>
	</fieldset>

	<?php if  ( ! $this->settings_lib->item('auth.use_extended_profile')) :?>
	<fieldset>
		<legend><?php echo lang('us_address'); ?></legend>

		<div class="control-group">
			<label class="control-label" for="street_1"><?php echo lang('us_street_1'); ?></label>
			<div class="controls">
				<input type="text" name="street_1" class="span6" value="<?php echo isset($user) ? $user->street_1 : set_value('street_1') ?>" />
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="street_2"><?php echo lang('us_street_2'); ?></label>
			<div class="controls">
				<input type="text" name="street_2" class="span6" value="<?php echo isset($user) ? $user->street_2 : set_value('street_2') ?>" />
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="city"><?php echo lang('us_city'); ?></label>
			<div class="controls">
				<input type="text" name="city" class="span6" value="<?php echo isset($user) ? $user->city : set_value('city') ?>" />
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="iso"><?php echo lang('us_country'); ?></label>
			<div class="controls">
				<?php echo country_select(isset($user) && !empty($user->country_iso) ? $user->country_iso : 'US', 'US'); ?>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="state_code"><?php echo lang('us_state'); ?></label>
			<div class="controls">
				<?php echo state_select(isset($user) ? $user->state_code : '', 'SC', isset($user) && !empty($user->country_iso) ? $user->country_iso : 'US'); ?>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="zipcode"><?php echo lang('us_zipcode'); ?></label>
			<div class="controls">
				<input type="text" name="zipcode" class="span6" value="<?php echo isset($user) ? $user->zipcode : set_value('zipcode') ?>" />
			</div>
		</div>

	</fieldset>
	<?php endif; ?>
