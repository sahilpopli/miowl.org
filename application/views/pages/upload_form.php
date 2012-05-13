<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			Upload a new file
		</center>
	</h1>

	<div id="body">

        <!-- login -->
        <form action="" class="uniForm" method="post">

            <?php $this->load->view('messages/message_inline'); ?>

            <fieldset class="inlineLabels">

                <div class="ctrlHolder">
                    <label for="userfile">File (required)</label>
                    <input type="file" name="userfile" id="userfile" size="35" class="textInput medium" value="<?php print set_value('userfile'); ?>" />
                    <p class="formHint">Choose the file you want to upload. Must be <strong><?php print $allow_types; ?></strong></p>
                </div>

                <div class="ctrlHolder">
                    <label for="filename">Name</label>
                    <input type="text" name="filename" id="filename" size="35" class="textInput medium" value="<?php print set_value('filename'); ?>" />
                    <p class="formHint">Choose the file's display name.<br><strong>NOTE:</strong> leave blank to use the uploaded filename.</p>
                </div>

                <div class="ctrlHolder">
                    <label for="catagory">Catagory</label>
                    <select name="category" id="category" class="textInput medium" autocompelete="OFF" />
                        <?php foreach ($categories->result() as $row) : ?>
                        <?php if ($row->parent_id == "0") : ?>
                            <option value="<?php print $row->id; ?>" <?php echo set_select('category', $row->id); ?>>
                                <?php print $row->name; ?>
                            </option>
                        <?php endif; endforeach; ?>
                    </select>
                    <p class="formHint">Choose the file's catagory.</p>
                </div>

                <div class="ctrlHolder">
                    <label for="description">Description (required)</label>
                    <textarea name="description" id="description" size="35" class="textInput medium" rows="5" cols="50"><?php print trim(set_value('description')); ?></textarea>
                    <p class="formHint">Enter a description for the file.</p>
                </div>

            </fieldset>

            <div class="buttonHolder">
                <button class="button" type="submit">Upload</button>
            </div>

        </form>

	</div>

<?php $this->load->view('template/footer'); ?>
