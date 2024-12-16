<?php
function wvl_get_terms_limit($venue_id)
{
    if (wvl_current_plan() == 'free') {
        return 1;
    }
    return -1;
}

function wvl_get_gallery_upload_limit($venue_id)
{
    if (wvl_current_plan() != 'free') {
        return 1000;
    }
    $gallery = get_post_meta($venue_id, 'venue_gallery', true);
    $total_available_gallery_upload = 5;
    if ($gallery && is_array($gallery)) {

        if ($total_available_gallery_upload <= count($gallery)) {
            $total_available_gallery_upload = 0;
        } else {
            $total_available_gallery_upload -= count($gallery);
        }
    }

    return $total_available_gallery_upload;
}


function wvl_get_support_location_limit($venue_id)
{
    if (wvl_current_plan() == 'free') {
        return 1;
    }
    return -1;
}
