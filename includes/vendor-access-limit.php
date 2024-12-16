<?php
function wvl_get_terms_limit($taxonomy)
{
    if (wvl_current_plan() == 'free') {
        return 1;
    }
    return -1;
}
