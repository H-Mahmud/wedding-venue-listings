(function ($) {
    var $body = $('body'); var converter = new DateConverter(); converter.setCurrentDate(); let today = converter.nepaliYear + '-' + converter.nepaliMonth + '-' + converter.nepaliDate; $('form').attr('autocomplete', 'off'); var cal_no = 1; var cal_id = ''; var this_year = converter.getNepaliYear(); var this_month = converter.getNepaliMonth(); var start_year = 2000; var end_year = 2098; var single_datepicker = 0; var locale = 'np'; var $year_select = ''; var $month_select = ''; var $days_container = ''; var user_selected_dates = []; var last_captured_date = ''; var input_field_name = ''; var os = 'win'; var $selector = ''; var $form = ''; var sel_input; $.fn.nepaliDatePicker = function () {
        if (navigator.platform.toUpperCase().indexOf('MAC') >= 0) { os = 'mac' }
        $(this).each(function () {
            let $this = $(this); $(this).attr('data-cal_id', 'cal-' + cal_no); cal_no++; $(this).addClass('andp-date-picker'); var default_value = $.trim($(this).attr('value')); let data_single = $(this).data('single'); locale = $(this).data('locale'); if (data_single == !0 || data_single == 1) { single_datepicker = 1 } else { single_datepicker = 0 }
            if (default_value && !single_datepicker) {
                $form = $(this).parents('form'); cal_id = $(this).data('cal_id'); input_field_name = $(this).attr('name'); let default_dates = default_value.split(','); default_dates.forEach(function (item, index) { generate_hidden_input_fields(item.trim()) })
                if ($(this).data('show_all_dates') != !0) {
                    if (default_dates.length > 1) { output_msg = default_dates.length + ' dates selected' } else { output_msg = default_dates[0] }
                    $(this).attr('value', output_msg)
                } else { if (!$this.is('input')) { let default_dates = default_value.split(','); let temp_markup = '<span>' + default_dates.join('</span><span>') + '</span>'; $this.append(temp_markup) } }
            }
        })
        $(this).click(function () {
            sel_input = this; user_selected_dates = []; $selector = $(this); data_single = $(this).data('single'); if (data_single == !0 || data_single == 1) { single_datepicker = 1 } else { single_datepicker = 0 }
            cal_id = $(this).data('cal_id'); init(this); if (single_datepicker) { selected_date = format_date_yyyy_mm_dd($(this).val()); if (selected_date.length > 0) { older_date_ar = selected_date.split('-'); $month_select.val(older_date_ar[1]).change(); $year_select.val(older_date_ar[0]).change(); select_date(selected_date) } else { select_date(today, !0) } } else {
                $form = $(this).parents('form'); input_field_name = $(this).attr('name'); if (input_field_name) { $(this).removeAttr('name', '').attr('data-name', input_field_name) } else { input_field_name = $(this).attr('data-name') }
                var $hidden_publish_dates = $('input.andp-hidden-dates[data-cal_id="' + cal_id + '"]'); var total_hidden_dates = $hidden_publish_dates.length; if (total_hidden_dates > 0) {
                    if (total_hidden_dates == 1) { selected_date = format_date_yyyy_mm_dd($hidden_publish_dates.eq(0).val()); older_date_ar = selected_date.split('-'); $month_select.val(older_date_ar[1]).change(); $year_select.val(older_date_ar[0]).change(); select_date(selected_date) } else {
                        older_date = $('input.andp-hidden-dates[data-cal_id="' + cal_id + '"]'); let total_older_date = older_date.length; older_date = format_date_yyyy_mm_dd(older_date.eq((total_older_date - 1)).val()); if (older_date && older_date.length > 0) { older_date_ar = older_date.split('-'); $month_select.val(older_date_ar[1]).change(); $year_select.val(older_date_ar[0]).change() }
                        $hidden_publish_dates.each(function () { let sel_date = format_date_yyyy_mm_dd($(this).val()); select_date(sel_date) })
                    }
                } else { select_date(today, !0) }
            }
        })
        $body.on('change', '.andp-month-select, .andp-year-select', function () { generate_days() })
    }; $body.on('click', '.andp-datepicker-container.open .andp-change-months', function (event) {
        selected_month = parseInt($month_select.val()); selected_year = parseInt($year_select.val()); if ($(this).hasClass('andp-next')) { selected_month = selected_month + 1; if (selected_month > 12) { selected_month = 1; selected_year = selected_year + 1; if (selected_year > end_year) { selected_year = end_year; selected_month = 12 } } } else { selected_month = selected_month - 1; if (selected_month < 1) { selected_month = 12; selected_year = selected_year - 1; if (selected_year < start_year) { selected_year = start_year; selected_month = 1 } } }
        if (selected_month < 10) { selected_month = '0' + selected_month }
        if (selected_year < 10) { selected_year = '0' + selected_year }
        $month_select.val(selected_month).change(); $year_select.val(selected_year).change()
    }); const localizeNumber = (number) => { if (locale === 'np') { return number.toLocaleString('ne-NP', { useGrouping: !1 }) } else { return number } }
    $body.on('click', '.andp-datepicker-container.open .andp-days-numbers .day', function (event) {
        selected_day = $(this).text(); selected_date = $(this).data('date'); var $sel_calendar = $('.andp-datepicker-container[data-cal_id="' + cal_id + '"]'); if (single_datepicker) { user_selected_dates = []; $sel_calendar.find('.andp-column .day').removeClass('selected'); select_date(selected_date); $sel_calendar.find('.andp-info').hide(); update_sel_date_in_ui() } else { if (event.shiftKey) { var total_captured_dates = user_selected_dates.length; if (total_captured_dates > 0) { selected_date = $(this).data('date'); last_captured_date = user_selected_dates[total_captured_dates - 1]; var smaller_date = (find_older_date(selected_date, last_captured_date)) ? last_captured_date : selected_date; var next_date = smaller_date; var days_difference = get_days_difference(selected_date, last_captured_date); user_selected_dates = []; $sel_calendar.find('.andp-column .day').removeClass('selected'); select_date(next_date); for (i = 1; i <= days_difference; i++) { next_date = get_next_day(next_date); select_date(next_date) } } } else if (event.ctrlKey || event.metaKey) { select_date(selected_date) } else { user_selected_dates = []; $sel_calendar.find('.andp-column .day').removeClass('selected'); select_date(selected_date); $sel_calendar.find('.andp-info').show() } }
        $("document").trigger("andp_date_selected", [user_selected_dates, sel_input])
    })
    $body.on('click', function (e) { var container = $(".andp-datepicker-container, .andp-date-picker"); if (!container.is(e.target) && container.has(e.target).length === 0) { $(".andp-datepicker-container").removeClass('open').hide() } }); $body.on('click', '.andp-datepicker-container.open .apply-date', function () { update_sel_date_in_ui() })
    function format_date_yyyy_mm_dd(date) {
        if (date.length < 1) { return '' }
        let date_ar = date.split('-'); let new_date = date_ar[0] + '-'; new_date += (date_ar[1].length == 1) ? '0' + date_ar[1] : date_ar[1]; new_date += '-'; new_date += (date_ar[2].length == 1) ? '0' + date_ar[2] : date_ar[2]; return new_date
    }
    function update_sel_date_in_ui() {
        let total_user_selected_dates = user_selected_dates.length; if (total_user_selected_dates < 1) { $(".andp-datepicker-container").removeClass('open').hide(); return }
        user_selected_dates = user_selected_dates.sort(function (a, b) { a = a.split('/').reverse().join(''); b = b.split('/').reverse().join(''); return a > b ? 1 : a < b ? -1 : 0 }); if (single_datepicker) { $selector.attr('value', user_selected_dates[0]).val(user_selected_dates[0]).change() } else {
            $('input.andp-hidden-dates[data-cal_id="' + cal_id + '"]').remove(); for (i = 0; i <= total_user_selected_dates - 1; i++) { generate_hidden_input_fields(user_selected_dates[i]) }
            var output_msg = ''; if ($selector.data('show_all_dates') == !0) { if ($selector.is(':input')) { output_msg = user_selected_dates.join(', ') } else { output_msg = '<span>' + user_selected_dates.join('</span><span>') + '</span>' } } else { if (total_user_selected_dates > 1) { output_msg = total_user_selected_dates + ' dates selected' } else { output_msg = user_selected_dates[0] } }
            if ($selector.is(':input')) { $selector.attr('value', output_msg).val(output_msg) } else { $selector.html(output_msg) }
        }
        $(".andp-datepicker-container").removeClass('open').hide(); selected_date = $(this).data('date')
    }
    function init(this_sel) {
        $('.andp-datepicker-container').removeClass('open').hide(); var $sel_calendar = $('.andp-datepicker-container[data-cal_id="' + cal_id + '"]'); if ($sel_calendar.length > 0) { $year_select = $sel_calendar.find('.andp-year-select'); $month_select = $sel_calendar.find('.andp-month-select'); $days_container = $sel_calendar.find('.andp-days-numbers'); $sel_calendar.addClass('open').show(); fix_calendar_alignment(); return }
        var template = '<div class="andp-datepicker-container" data-cal_id="' + cal_id + '" >'; template += '<div class = "andp-header">'; template += '<button type = "button"  class = "andp-prev andp-change-months"> &#10094; </button>'; template += '<select class = "andp-month-select"> </select>'; template += '<select class = "andp-year-select"> </select>'; template += '<button type = "button" class = "andp-next andp-change-months"> &#10095; </button> '; template += '</div>'; template += '<div class="andp-body">'; if (locale == 'np') { template += '<div class = "andp-days-names"> <div> आ </div> <div> सो </div> <div> मं </div> <div> बु </div> <div> बि </div> <div> शु </div> <div> श </div> </div>' } else { template += '<div class = "andp-days-names"> <div> SUN </div> <div> MON </div> <div> TUE </div> <div> WED </div> <div> THU </div> <div> FRI </div> <div> SAT </div> </div>' }
        template += '<div class = "andp-days-numbers"> </div>'; if (!single_datepicker) {
            if (os == 'mac') { control_key = 'CMD' } else { control_key = 'CTRL' }
            template += '<div class="andp-info" style="display:none"><i class="mdi mdi-information text-primary"></i> Press <strong>' + control_key + '</strong> or <strong>Shift</strong> key for multiple selection </div>'
        }
        template += '<div class="andp-action-btns">'; if (!single_datepicker) { template += '<button type="button" class="apply-date" data-cal_id="' + cal_id + '">Apply</button>' }
        template += '</div>'; template += '</div>'; template += '</div>'; $body.append(template); $sel_calendar = $('.andp-datepicker-container[data-cal_id="' + cal_id + '"]'); $year_select = $sel_calendar.find('.andp-year-select'); $month_select = $sel_calendar.find('.andp-month-select'); $days_container = $sel_calendar.find('.andp-days-numbers'); append_html = '<option value = "01" ' + (('01' == this_month) ? 'selected' : ' ') + ' > ' + (locale === 'np' ? 'बैशाख' : 'Baisakh') + '</option>'; append_html += '<option value = "02" ' + (('02' == this_month) ? 'selected' : '') + ' > ' + (locale === 'np' ? 'जेठ' : 'Jestha') + '</option>'; append_html += '<option value = "03" ' + (('03' == this_month) ? 'selected' : '') + ' > ' + (locale === 'np' ? 'असार' : 'Asar') + '</option>'; append_html += '<option value = "04" ' + (('04' == this_month) ? 'selected' : '') + ' > ' + (locale === 'np' ? 'साउन' : 'Shrawan') + '</option>'; append_html += '<option value = "05" ' + (('05' == this_month) ? 'selected' : '') + ' > ' + (locale === 'np' ? 'भदौ' : 'Bhadra') + '</option>'; append_html += '<option value = "06" ' + (('06' == this_month) ? 'selected' : '') + ' > ' + (locale === 'np' ? 'असोज' : 'Ashoj') + '</option>'; append_html += '<option value = "07" ' + (('07' == this_month) ? 'selected' : '') + ' > ' + (locale === 'np' ? 'कार्तिक' : 'Kartik') + '</option>'; append_html += '<option value = "08" ' + (('08' == this_month) ? 'selected' : '') + ' > ' + (locale === 'np' ? 'मंसिर' : 'Mangsir') + '</option>'; append_html += '<option value = "09" ' + (('09' == this_month) ? 'selected' : '') + ' > ' + (locale === 'np' ? 'पुष' : 'Poush') + '</option>'; append_html += '<option value = "10" ' + (('10' == this_month) ? 'selected' : '') + ' > ' + (locale === 'np' ? 'माघ' : 'Magh') + '</option>'; append_html += '<option value = "11" ' + (('11' == this_month) ? 'selected' : '') + ' > ' + (locale === 'np' ? 'फागुन' : 'Falgun') + '</option>'; append_html += '<option value = "12" ' + (('12' == this_month) ? 'selected' : '') + ' > ' + (locale === 'np' ? 'चैत' : 'Chaitra') + '</option>'; $month_select.append(append_html); for (i = start_year; i <= end_year; i++) {
            append_html = '<option value="' + i + '"'; if (i == this_year) { append_html += ' selected' }
            append_html += '>' + localizeNumber(i) + '</option>'; $year_select.append(append_html)
        }
        generate_days(); $('.andp-datepicker-container[data-cal_id="' + cal_id + '"]').addClass('open'); fix_calendar_alignment()
    }
    function fix_calendar_alignment() { var elem_pos = $selector.offset(); var elem_height = $selector.outerHeight(); var document_width = $(window).width(); var selector_width = $selector.outerWidth(); var calendar_width = $('.andp-datepicker-container').outerWidth(); if (calendar_width + elem_pos.left + 10 > document_width) { var right_offset = document_width - (elem_pos.left + selector_width); $('.andp-datepicker-container[data-cal_id="' + cal_id + '"]').css({ 'top': elem_pos.top + elem_height, 'right': right_offset, 'left': 'inherit' }) } else { $('.andp-datepicker-container[data-cal_id="' + cal_id + '"]').css({ 'top': elem_pos.top + elem_height, 'left': elem_pos.left, 'right': 'inherit' }) } }
    function generate_days() {
        month = $month_select.val(); year = $year_select.val(); $days_container.html(''); var selected_date_obj = new DateConverter(); selected_date_obj.setNepaliDate(year, month, 1); var month_start_day = selected_date_obj.getDay(); var total_days_in_selected_month = getDaysInMonth(year, month); append_html = ''; var y = 1; var j = 1; var k = parseInt(month_start_day) - 2; var l = 1; for (i = 1; i <= 42; i++) {
            last_month = parseInt(month) - 1; last_year = parseInt(year); if (last_month < 1) { last_month = 12; last_year = last_year - 1; if (last_year < start_year) { last_year = start_year; last_month = 1 } }
            next_month = parseInt(month) + 1; next_year = parseInt(year); var total_days_in_last_month = getDaysInMonth(last_year, last_month); if (y == 1) { append_html += '<div class="andp-column">' }
            if (i < month_start_day) { append_html += '<div class="old-dates"> ' + localizeNumber(parseInt(total_days_in_last_month - k)) + ' </div>'; k = k - 1 } else { if (j <= total_days_in_selected_month) { let day = (j < 10 ? '0' + j : j); let proper_date = year + '-' + month + '-' + day; let ar_index = user_selected_dates.indexOf(proper_date); append_html += '<div class="day' + ((ar_index >= 0) ? ' selected' : '') + '" data-date="' + proper_date + '">' + localizeNumber(j) + '</div>'; j++ } else { append_html += '<div  class="old-dates"> ' + localizeNumber(l) + '</div>'; l++ } }
            if (y == 7) { append_html += '</div>'; y = 0 }
            y++
        }
        $days_container.append(append_html)
    }
    function getDaysInMonth(year, month) { var converter = new DateConverter(); if (year < start_year || year > end_year) return; if (month < 1 || month > 12) return; var year = year - start_year; var month = month - 1; return converter.nepaliMonths[year][month] }
    function get_days_difference(date_1, date_2) { date_1 = date_1.split('-'); date_2 = date_2.split('-'); var converter = new DateConverter(); converter.setNepaliDate(date_1[0], date_1[1], date_1[2]); return converter.getNepaliDateDifference(date_2[0], date_2[1], date_2[2]) }
    function find_older_date(date_1, date_2) { date_1 = date_1.split('-'); date_2 = date_2.split('-'); var converter = new DateConverter(); converter.setNepaliDate(date_1[0], date_1[1], date_1[2]); var date_1_eng = [converter.getEnglishYear(), converter.getEnglishMonth(), converter.getEnglishDate()]; converter.setNepaliDate(date_2[0], date_2[1], date_2[2]); var date_2_eng = [converter.getEnglishYear(), converter.getEnglishMonth(), converter.getEnglishDate()]; var firstDate = new Date(date_1_eng[0], date_1_eng[1], date_1_eng[2]); var secondDate = new Date(date_2_eng[0], date_2_eng[1], date_2_eng[2]); if (firstDate > secondDate) { return 1 } else { return !1 } }
    function get_next_day(date_1) {
        date_1 = date_1.split('-'); year = parseInt(date_1[0]); month = parseInt(date_1[1]); var days_in_month = parseInt(getDaysInMonth(year, month)); day = parseInt(date_1[2]) + 1; if (day > days_in_month) { day = 1; month = month + 1; if (month > 12) { month = 1; year = year + 1 } }
        return year + '-' + month + '-' + day
    }
    function select_date(selected_date, soft_select = !1) { selected_date = format_date_yyyy_mm_dd(selected_date); var ar_index = user_selected_dates.indexOf(selected_date); var $sel_calendar = $('.andp-datepicker-container[data-cal_id="' + cal_id + '"]'); var $this = $sel_calendar.find('.day[data-date="' + selected_date + '"]'); if (soft_select) { $this.addClass('soft-select') } else { if (ar_index < 0) { user_selected_dates.push(selected_date); $this.addClass('selected') } else { user_selected_dates.splice(ar_index, 1); $this.removeClass('selected') } } }
    function generate_hidden_input_fields(value) { $form.append('<input class="andp-hidden-dates" type="hidden" data-cal_id="' + cal_id + '" name="' + input_field_name + '[]" value="' + value + '">') }
    function DateConverter() {
        this.englishMonths = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]; this.englishLeapMonths = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]; this.nepaliMonths = [[30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31], [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30], [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31], [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31], [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30], [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31], [31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 29, 31], [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30], [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31], [31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30], [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30], [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31], [31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30], [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31], [31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30], [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31], [31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30], [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31], [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31], [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30], [31, 31, 32, 31, 32, 30, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31], [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31], [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30], [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31], [30, 32, 31, 32, 31, 31, 29, 30, 30, 29, 29, 31], [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30], [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31], [31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30], [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30], [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31], [31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30], [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31], [31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30], [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31], [31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30], [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31], [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30], [31, 31, 32, 31, 32, 30, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31], [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31], [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30], [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31], [30, 32, 31, 32, 31, 31, 29, 30, 29, 30, 29, 31], [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30], [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31], [31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 29, 31], [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30], [31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31], [31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30], [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31], [31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30], [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31], [31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30], [31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30], [31, 31, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30], [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30], [31, 31, 32, 31, 31, 30, 30, 30, 29, 30, 30, 30], [31, 31, 32, 31, 31, 30, 30, 30, 29, 30, 30, 30], [31, 32, 31, 32, 30, 31, 30, 30, 29, 30, 30, 30], [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30], [31, 31, 32, 31, 31, 31, 30, 30, 29, 30, 30, 30], [30, 31, 32, 32, 30, 31, 30, 30, 29, 30, 30, 30], [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30], [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30], [31, 31, 32, 31, 31, 31, 30, 30, 29, 30, 30, 30], [30, 31, 32, 32, 31, 30, 30, 30, 29, 30, 30, 30], [30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30], [31, 31, 32, 31, 31, 30, 30, 30, 29, 30, 30, 30], [31, 31, 32, 31, 31, 31, 30, 29, 30, 30, 30, 30], [30, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30], [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 30, 30], [31, 31, 32, 31, 31, 31, 29, 30, 29, 30, 29, 31], [31, 31, 32, 31, 31, 31, 30, 29, 29, 30, 30, 30]]; this.setCurrentDate = function () { var d = new Date(); this.setEnglishDate(d.getFullYear(), d.getMonth() + 1, d.getDate()) }; this.setEnglishDate = function (year, month, date) {
            if (!this.isEnglishRange(year, month, date))
                throw new Exception("Invalid date format."); this.englishYear = year; this.englishMonth = month; this.englishDate = date; this.nepaliYear = 2000; this.nepaliMonth = 1; this.nepaliDate = 1; var difference = this.getEnglishDateDifference(1943, 4, 14); var index = 0; while (difference >= this.nepaliYearDays(index)) { this.nepaliYear++; difference = difference - this.nepaliYearDays(index); index++ }
            var i = 0; while (difference >= this.nepaliMonths[index][i]) { difference = difference - this.nepaliMonths[index][i]; this.nepaliMonth++; i++ }
            this.nepaliDate = this.nepaliDate + difference; this.getDay()
        }; this.toEnglishString = function (format) {
            if (typeof (format) === 'undefined')
                format = "-"; return this.englishYear + format + this.englishMonth + format + this.englishDate
        }; this.getEnglishDateDifference = function (year, month, date) { var difference = this.countTotalEnglishDays(this.englishYear, this.englishMonth, this.englishDate) - this.countTotalEnglishDays(year, month, date); return (difference < 0 ? -difference : difference) }; this.countTotalEnglishDays = function (year, month, date) {
            var totalDays = year * 365 + date; for (var i = 0; i < month - 1; i++)
                totalDays = totalDays + this.englishMonths[i]; totalDays = totalDays + this.countleap(year, month); return totalDays
        }; this.countleap = function (year, month) {
            if (month <= 2)
                year--; return (Math.floor(year / 4) - Math.floor(year / 100) + Math.floor(year / 400))
        }; this.isEnglishRange = function (year, month, date) {
            if (year < 1944 || year > 2042)
                return !1; if (month < 1 || month > 12)
                return !1; if (date < 1 || date > 31)
                return !1; return !0
        }; this.isLeapYear = function (year) { if (year % 4 === 0) { return (year % 100 === 0) ? (year % 400 === 0) : !0 } else return !1 }; this.setNepaliDate = function (year, month, date) {
            if (!this.isNepaliRange(year, month, date)) { console.log('Invalid Date Format'); return }
            this.nepaliYear = year; this.nepaliMonth = month; this.nepaliDate = date; this.englishYear = 1944; this.englishMonth = 1; this.englishDate = 1; var difference = this.getNepaliDateDifference(2000, 9, 17); while (difference >= (this.isLeapYear(this.englishYear) ? 366 : 365)) { difference = difference - (this.isLeapYear(this.englishYear) ? 366 : 365); this.englishYear++ }
            var monthDays = this.isLeapYear(this.englishYear) ? this.englishLeapMonths : this.englishMonths; var i = 0; while (difference >= monthDays[i]) { this.englishMonth++; difference = difference - monthDays[i]; i++ }
            this.englishDate = this.englishDate + difference; this.getDay()
        }; this.toNepaliString = function (format) {
            if (typeof (format) === 'undefined')
                format = "-"; return this.nepaliYear + format + this.nepaliMonth + format + this.nepaliDate
        }; this.getNepaliDateDifference = function (year, month, date) { var difference = this.countTotalNepaliDays(this.nepaliYear, this.nepaliMonth, this.nepaliDate) - this.countTotalNepaliDays(year, month, date); return (difference < 0 ? -difference : difference) }; this.countTotalNepaliDays = function (year, month, date) {
            var total = 0; if (year < 2000)
                return 0; total = total + (date - 1); var yearIndex = year - 2000; for (var i = 0; i < month - 1; i++)
                total = total + this.nepaliMonths[yearIndex][i]; for (var i = 0; i < yearIndex; i++)
                total = total + this.nepaliYearDays(i); return total
        }; this.nepaliYearDays = function (index) {
            var total = 0; for (var i = 0; i < 12; i++)
                total += this.nepaliMonths[index][i]; return total
        }; this.isNepaliRange = function (year, month, date) {
            if (year < 2000 || year > 2098)
                return !1; if (month < 1 || month > 12)
                return !1; if (date < 1 || date > this.nepaliMonths[year - 2000][month - 1])
                return !1; return !0
        }; this.getDay = function () { var difference = this.getEnglishDateDifference(1943, 4, 14); this.weekDay = ((3 + (difference % 7)) % 7) + 1; return this.weekDay }; this.getEnglishYear = function () { return this.englishYear }; this.getEnglishMonth = function () { return this.englishMonth }; this.getEnglishDate = function () { return this.englishDate }; this.getNepaliYear = function () { return this.nepaliYear }; this.getNepaliMonth = function () { return this.nepaliMonth }; this.getNepaliDate = function () { return this.nepaliDate }
    }
}(jQuery))
