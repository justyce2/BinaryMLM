/**
 * @file Custom JS Functions
 * @copyright Techplait 2019
 */

function change_status(id, new_val, post_url) {
    $.ajax({
        url: post_url,
        type: 'post',
        data: {id: id, new_val : new_val},
        success: function(result) {
            $.pjax({container: '#w0'});
        }
    });
}