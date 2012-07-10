<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			Owl Licenses
		</center>
	</h1>

    <div id="body">
        <div id="owl_nav" class="column left quarter">
            <?php $this->load->view('pages/owl_nav'); ?>
        </div>
        <div id="owl_body" class="column right threequarter">

            <table>
                <thead>
                    <tr>
                        <th>name</th>
                        <th>description</th>
                        <th>url</th>
                        <th>in use?</th>
                        <th>edit</th>
                        <th>remove</th>
                    </tr>
                </thead>
                <tbody>

<?php
    if($licenses) :
    foreach($licenses->result() as $row) :
        $is_in_use = $this->lic_model->in_use($row->id);
?>
                    <tr id="r-<?php print $row->id; ?>">
                        <td><?php print $row->name; ?></td>
                        <td><?php print $row->short_description; ?></td>
                        <td><a href="<?php print $row->url; ?>" target="_BLANK"><?php print $row->url; ?></a></td>
                        <td>
                            <?php if ( $is_in_use ) : ?>
                                <span style="color:#63b52e !important;" class="icon_font">.</span>
                            <?php else : ?>
                                <span style="color:#FF0000 !important;" class="icon_font">'</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a style="color:#63b52e !important;" href="<?php print $row->id; ?>" class="licedit"><img src="/images/icons/edit.gif" title="edit this license" alt="edit" width="16px" height="16px" /></a>
                        </td>
                        <td>
                            <?php if ($is_in_use) : ?>
                                <span style="color:#FF0000 !important; opacity: 0.25 !important;"><img src="/images/icons/recycle_bin.png" title="cannot remove this license" alt="cannot remove" width="25px" height="25px" /></span>
                            <?php else : ?>
                                <a style="color:#FF0000 !important;" href="<?php print $row->id; ?>" class="del"><img src="/images/icons/recycle_bin.png" title="remove this license" alt="remove" width="25px" height="25px" /></a>
                            <?php endif; ?>
                        </td>
                    </tr>
<?php
    endforeach;
    endif;
?>

                </tbody>
            </table>

            <!-- pagination -->
            <div class="pagination">
                <center><?php print $this->pagination->create_links(); ?></center>
            </div>

        </div>
        <div class="clear">&nbsp;</div>
    </div>

    <!-- Page Javascript -->
    <script type="text/javascript">
        $(function() {
            $('.del').click(function(e) {
                // prevent the default action, e.g., following a link
                e.preventDefault();

                // get the data from the form
                var lic_id = $(this).attr('href');

                // setup and load the dialog box
                $('<div></div>').html('<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This will delete the license <strong>' + cat_name + '</strong>').dialog({
                    title: 'delete this license?',
                    autoOpen: true,
                    resizable: false,
                    modal: true,
                    buttons: {
                        "Confirm": function() {
                            // close the dialog box
                            $(this).dialog("close");

                            // build the uri
                            var uri = '/owl/licenses/remove/' + cat_id;

                            // get the JSON data from the request
                            $.getJSON(uri, function(data) {
                                if (data.success == 'true') {
                                    // update the view to reflect this change
                                    $('#r-' + cat_id).fadeOut('slow', function() {
                                        $('#r-' + cat_id).empty();
                                    });
                                }
                                else {
                                    alert('Sorry, an error has occured. Please report this to the site admin.');
                                }
                            });
                        },
                        Cancel: function() {
                            $(this).dialog("close");
                        }
                    }
                });
            });
        });

        $(function() {
            $('.licedit').click(function(e) {
                // prevent the default action, e.g., following a link
                e.preventDefault();

                // remove the previous dialog box if there is one
                $( "#dialog" ).remove();

                // get the data from the form
                var lic_id = $(this).attr('href');

                // get the owl list
                $.getJSON('/owl/licenses/info/' + lic_id, function(info) {
                    var obj = $(info).first();
                    // create and load the dialog form
                    $('<div id="dialog"></div>')
                        .html('<p class="validateTips">All form fields are required.</p><fieldset><span class="left">Name</span><input type="text" id="dialog_name" class="text ui-widget-content ui-corner-all right" style="width: 185px;" value="' + obj.name + '" /><br /><span class="left">Description</span><input type="text" id="dialog_desc" class="text ui-widget-content ui-corner-all right" style="width: 185px;" value="' + obj.short_description + '" /><br /><span class="left">URL</span><input type="text" id="dialog_url" class="text ui-widget-content ui-corner-all right" style="width: 185px;" value="' + obj.url + '" />')
                        .dialog({
                            title: 'Edit the license',
                            autoOpen: true,
                            resizable: false,
                            width: 350,
                            modal: true,
                            buttons: {
                                "Edit": function() {
                                    var name = $("#dialog_name"),
                                        desc = $("#dialog_desc"),
                                        url = $("#dialog_url"),
                                        allFields = $([]).add(name).add(subcat).add(url);

                                    allFields.removeClass("ui-state-error");

                                    // get the JSON data from the request
                                    $.post('/owl/licenses/edit/', {
                                        id: lic_id,
                                        name: name.val(),
                                        desc: desc.val(),
                                        url: url.val()
                                    },
                                    function(response) {
                                        // was the edit a success?
                                        if (response.success) {
                                            // get the new breadcrumb
                                            $.get('/owl/licenses/breadcrumb/' + cat_id, function(data) {
                                                // var breadcrumb = response;
                                                $('td:first', $('#r-' + cat_id)).html(data);
                                            }, "html");

                                            // update the href to reflect this change
                                            var new_uri = cat_id + ':' + response.subcat + ':' + response.namez;
                                            $('.del', $('#r-' + cat_id)).attr('href', new_uri);
                                            $('.licedit', $('#r-' + cat_id)).attr('href', new_uri);
                                        }
                                        else {
                                            alert('Sorry, an error has occured. Please report this to the site admin.');
                                        }
                                    }, "json");

                                    // close the dialog box
                                    $(this).dialog("close");
                                },
                                Cancel: function() {
                                    $(this).dialog("close");
                                }
                            },
                            close: function() {
                                var name = $("#dialog_name"),
                                    subcat = $("#dialog_subcat"),
                                    allFields = $([]).add(name).add(subcat);

                                allFields.val("").removeClass("ui-state-error");
                            }
                    });
                },
                "html");
            });
        });
    </script>
    <!-- --------------- -->

<?php $this->load->view('template/footer'); ?>
