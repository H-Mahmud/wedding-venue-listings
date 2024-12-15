export function showProfileNextSpinner() {
    jQuery('#profileFormNext').find('.spinner').removeClass('hidden');
    jQuery('#profileFormNext').find('.spinner').addClass('inline');
    jQuery('#profileFormNext').find('.next').hide();
    jQuery('#profileFormNext').find('.loading').show();
}

export function hideProfileNextSpinner() {
    jQuery('#profileFormNext').find('.spinner').addClass('hidden');
    jQuery('#profileFormNext').find('.spinner').removeClass('inline');
    jQuery('#profileFormNext').find('.next').show();
    jQuery('#profileFormNext').find('.loading').hide();
}

export function showLoading() {
    jQuery('.wvl-loading').show();
}

export function hideLoading() {
    jQuery('.wvl-loading').hide();    
}
