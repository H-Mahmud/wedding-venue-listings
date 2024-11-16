<div class="pb-5">
    <h2 class="mb-4">Booked Calendar</h2>
    <div class="card">
        <div class="card-body p-0">
            <div id="calendar"></div>
        </div>
    </div>
</div>

<!-- calendar modal -->
<div id="modal-view-event" class="modal modal-top fade calendar-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="modal-title"><span class="event-icon"></span><span class="event-title"></span></h4>
                <div class="event-body"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="modal-view-event-add" class="modal modal-top fade calendar-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="add-event">
                <div class="modal-body">
                    <h4>Add Booking Detail</h4>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="ename">
                    </div>
                    <div class="form-group">
                        <label>Booked Date</label>
                        <input type='text' class="datetimepicker form-control" name="edate">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="edesc"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /*!
 * FullCalendar v3.9.0
 * Docs & License: https://fullcalendar.io/
 * (c) 2018 Adam Shaw
 */
    .fc {
        direction: ltr;
        text-align: left;
    }

    .fc-rtl {
        text-align: right;
    }

    body .fc {
        /* extra precedence to overcome jqui */
        font-size: 1em;
    }

    /* Colors
--------------------------------------------------------------------------------------------------*/
    .fc-highlight {
        /* when user is selecting cells */
        background: #bce8f1;
        opacity: .3;
    }

    .fc-bgevent {
        /* default look for background events */
        background: #8fdf82;
        opacity: .3;
    }

    .fc-nonbusiness {
        /* default look for non-business-hours areas */
        /* will inherit .fc-bgevent's styles */
        background: rgba(52, 40, 104, .05);
    }

    /* Buttons (styled <button> tags, normalized to work cross-browser)
--------------------------------------------------------------------------------------------------*/
    .fc button {
        /* force height to include the border and padding */
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        /* dimensions */
        margin: 0;
        height: auto;
        padding: 0 .6em;
        /* text & cursor */
        font-size: 1em;
        /* normalize */
        white-space: nowrap;
        cursor: pointer;
    }

    /* Firefox has an annoying inner border */
    .fc button::-moz-focus-inner {
        margin: 0;
        padding: 0;
    }

    .fc-state-default {
        /* non-theme */
        border: 1px solid;
    }

    .fc-state-default.fc-corner-left {
        /* non-theme */
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }

    .fc-state-default.fc-corner-right {
        /* non-theme */
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }

    /* icons in buttons */
    .fc button .fc-icon {
        /* non-theme */
        position: relative;
        top: -0.05em;
        /* seems to be a good adjustment across browsers */
        margin: 0 .2em;
        vertical-align: middle;
    }

    /*
  button states
  borrowed from twitter bootstrap (http://twitter.github.com/bootstrap/)
*/
    .fc-state-default {
        background-color: #f5f5f5;
        background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);
        background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));
        background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6);
        background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);
        background-image: linear-gradient(to bottom, #ffffff, #e6e6e6);
        background-repeat: repeat-x;
        border-color: #e6e6e6 #e6e6e6 #bfbfbf;
        border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
        color: #333;
        text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .fc-state-hover,
    .fc-state-down,
    .fc-state-active,
    .fc-state-disabled {
        color: #333333;
        background-color: #e6e6e6;
    }

    .fc-state-hover {
        color: #333333;
        text-decoration: none;
        background-position: 0 -15px;
        -webkit-transition: background-position 0.1s linear;
        -moz-transition: background-position 0.1s linear;
        -o-transition: background-position 0.1s linear;
        transition: background-position 0.1s linear;
    }

    .fc-state-down,
    .fc-state-active {
        background-color: #cccccc;
        background-image: none;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .fc-state-disabled {
        cursor: default;
        background-image: none;
        opacity: 0.65;
        box-shadow: none;
    }

    /* Buttons Groups
--------------------------------------------------------------------------------------------------*/
    .fc-button-group {
        display: inline-block;
    }

    /*
every button that is not first in a button group should scootch over one pixel and cover the
previous button's border...
*/
    .fc .fc-button-group>* {
        /* extra precedence b/c buttons have margin set to zero */
        float: left;
        margin: 0 0 0 -1px;
    }

    .fc .fc-button-group> :first-child {
        /* same */
        margin-left: 0;
    }

    /* Popover
--------------------------------------------------------------------------------------------------*/
    .fc-popover {
        position: absolute;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .fc-popover .fc-header {
        /* TODO: be more consistent with fc-head/fc-body */
        padding: 2px 4px;
    }

    .fc-popover .fc-header .fc-title {
        margin: 0 2px;
    }

    .fc-popover .fc-header .fc-close {
        cursor: pointer;
    }

    .fc-ltr .fc-popover .fc-header .fc-title,
    .fc-rtl .fc-popover .fc-header .fc-close {
        float: left;
    }

    .fc-rtl .fc-popover .fc-header .fc-title,
    .fc-ltr .fc-popover .fc-header .fc-close {
        float: right;
    }

    /* Misc Reusable Components
--------------------------------------------------------------------------------------------------*/
    .fc-divider {
        border-style: solid;
        border-width: 1px;
    }

    hr.fc-divider {
        height: 0;
        margin: 0;
        padding: 0 0 2px;
        /* height is unreliable across browsers, so use padding */
        border-width: 1px 0;
    }

    .fc-clear {
        clear: both;
    }

    .fc-bg,
    .fc-bgevent-skeleton,
    .fc-highlight-skeleton,
    .fc-helper-skeleton {
        /* these element should always cling to top-left/right corners */
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
    }

    .fc-bg {
        bottom: 0;
        /* strech bg to bottom edge */
    }

    .fc-bg table {
        height: 100%;
        /* strech bg to bottom edge */
    }

    /* Tables
--------------------------------------------------------------------------------------------------*/
    .fc table {
        width: 100%;
        box-sizing: border-box;
        /* fix scrollbar issue in firefox */
        table-layout: fixed;
        border-collapse: collapse;
        border-spacing: 0;
        font-size: 1em;
        /* normalize cross-browser */
    }

    .fc th {
        text-align: center;
    }

    .fc th,
    .fc td {
        border-style: solid;
        border-width: 1px 1px 0 1px !important;
        padding: 0;
        border-color: #eee;
        vertical-align: top;
    }

    .fc td.fc-today {
        border-style: double;
        /* overcome neighboring borders */
    }

    /* Internal Nav Links
--------------------------------------------------------------------------------------------------*/
    a[data-goto] {
        cursor: pointer;
    }

    a[data-goto]:hover {
        text-decoration: underline;
    }

    /* Fake Table Rows
--------------------------------------------------------------------------------------------------*/
    .fc .fc-row {
        /* extra precedence to overcome themes w/ .ui-widget-content forcing a 1px border */
        /* no visible border by default. but make available if need be (scrollbar width compensation) */
        border-style: solid;
        border-width: 0;
    }

    .fc-row table {
        /* don't put left/right border on anything within a fake row.
     the outer tbody will worry about this */
        border-left: 0 hidden transparent;
        border-right: 0 hidden transparent;
        /* no bottom borders on rows */
        border-bottom: 0 hidden transparent;
    }

    .fc-row:first-child table {
        border-top: 0 hidden transparent;
        /* no top border on first row */
    }

    /* Day Row (used within the header and the DayGrid)
--------------------------------------------------------------------------------------------------*/
    .fc-row {
        position: relative;
        background: #ffffff;
    }

    .fc-row .fc-bg {
        z-index: 1;
    }

    /* highlighting cells & background event skeleton */
    .fc-row .fc-bgevent-skeleton,
    .fc-row .fc-highlight-skeleton {
        bottom: 0;
        /* stretch skeleton to bottom of row */
    }

    .fc-row .fc-bgevent-skeleton table,
    .fc-row .fc-highlight-skeleton table {
        height: 100%;
        /* stretch skeleton to bottom of row */
    }

    .fc-row .fc-highlight-skeleton td,
    .fc-row .fc-bgevent-skeleton td {
        border-color: transparent;
    }

    .fc-row .fc-bgevent-skeleton {
        z-index: 2;
    }

    .fc-row .fc-highlight-skeleton {
        z-index: 3;
    }

    /*
row content (which contains day/week numbers and events) as well as "helper" (which contains
temporary rendered events).
*/
    .fc-row .fc-content-skeleton {
        position: relative;
        z-index: 4;
        padding-bottom: 2px;
        /* matches the space above the events */
    }

    .fc-row .fc-helper-skeleton {
        z-index: 5;
    }

    .fc .fc-row .fc-content-skeleton table,
    .fc .fc-row .fc-content-skeleton td,
    .fc .fc-row .fc-helper-skeleton td {
        /* see-through to the background below */
        /* extra precedence to prevent theme-provided backgrounds */
        background: none;
        /* in case <td>s are globally styled */
        border-color: transparent;
        padding: .5rem .5rem;
    }

    .fc-row .fc-content-skeleton td,
    .fc-row .fc-helper-skeleton td {
        /* don't put a border between events and/or the day number */
        border-bottom: 0;
    }

    .fc-row .fc-content-skeleton tbody td,
    .fc-row .fc-helper-skeleton tbody td {
        /* don't put a border between event cells */
        border-top: 0;
    }

    /* Scrolling Container
--------------------------------------------------------------------------------------------------*/
    .fc-scroller {
        -webkit-overflow-scrolling: touch;
    }

    /* TODO: move to agenda/basic */
    .fc-scroller>.fc-day-grid,
    .fc-scroller>.fc-time-grid {
        position: relative;
        /* re-scope all positions */
        width: 100%;
        /* hack to force re-sizing this inner element when scrollbars appear/disappear */
    }

    /* Global Event Styles
--------------------------------------------------------------------------------------------------*/
    .fc-event {
        position: relative;
        /* for resize handle and other inner positioning */
        display: block;
        /* make the <a> tag block */
        font-size: 12px;
        line-height: 1.3;
        letter-spacing: 0.02em;
        border-radius: 3px;
        font-weight: 500;
        border: 1px solid #ddd;
        -webkit-box-shadow: 0px 1px 15px rgba(0, 0, 0, 0.05);
        -moz-box-shadow: 0px 1px 15px rgba(0, 0, 0, 0.05);
        box-shadow: 0px 1px 15px rgba(0, 0, 0, 0.05);
        /* default BORDER color */
    }

    .fc-event,
    .fc-event-dot {
        background-color: #ffffff;
        color: #5d5386;
        position: relative;
        /* default BACKGROUND color */
    }

    .fc-event:before,
    .fc-event-dot:before {
        content: "";
        position: absolute;
        left: 0;
        bottom: -2px;
        width: 50px;
        height: 100%;
        border-left: 3px solid #5d5386;
        border-bottom: 3px solid #5d5386;
        -webkit-border-radius: 3px 0px 0px 3px;
        -moz-border-radius: 3px 0px 0px 3px;
        border-radius: 3px 0px 0px 3px;
    }

    .fc-event .fc-title {
        font-weight: 500;
    }

    .fc-event i {
        font-size: 26px;
        margin-right: 8px;
        vertical-align: middle;
    }

    .fc-event,
    .fc-event:hover {
        color: #fff;
        /* default TEXT color */
        text-decoration: none;
        /* if <a> has an href */
    }

    .fc-event[href],
    .fc-event.fc-draggable {
        cursor: pointer;
        /* give events with links and draggable events a hand mouse pointer */
    }

    .fc-not-allowed,
    .fc-not-allowed .fc-event {
        /* to override an event's custom cursor */
        cursor: not-allowed;
    }

    .fc-event .fc-bg {
        /* the generic .fc-bg already does position */
        z-index: 1;
        background: #fff;
        opacity: .25;
    }

    .fc-event .fc-content {
        color: #2c304d;
        position: relative;
        z-index: 2;
        padding: 8px;
    }

    /* resizer (cursor AND touch devices) */
    .fc-event .fc-resizer {
        position: absolute;
        z-index: 4;
    }

    /* resizer (touch devices) */
    .fc-event .fc-resizer {
        display: none;
    }

    .fc-event.fc-allow-mouse-resize .fc-resizer,
    .fc-event.fc-selected .fc-resizer {
        /* only show when hovering or selected (with touch) */
        display: block;
    }

    /* hit area */
    .fc-event.fc-selected .fc-resizer:before {
        /* 40x40 touch area */
        content: "";
        position: absolute;
        z-index: 9999;
        /* user of this util can scope within a lower z-index */
        top: 50%;
        left: 50%;
        width: 40px;
        height: 40px;
        margin-left: -20px;
        margin-top: -20px;
    }

    /* Event Selection (only for touch devices)
--------------------------------------------------------------------------------------------------*/
    .fc-event.fc-selected {
        z-index: 9999 !important;
        /* overcomes inline z-index */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .fc-event.fc-selected.fc-dragging {
        box-shadow: 0 2px 7px rgba(0, 0, 0, 0.3);
    }

    /* Horizontal Events
--------------------------------------------------------------------------------------------------*/
    /* bigger touch area when selected */
    .fc-h-event.fc-selected:before {
        content: "";
        position: absolute;
        z-index: 3;
        /* below resizers */
        top: -10px;
        bottom: -10px;
        left: 0;
        right: 0;
    }

    /* events that are continuing to/from another week. kill rounded corners and butt up against edge */
    .fc-ltr .fc-h-event.fc-not-start,
    .fc-rtl .fc-h-event.fc-not-end {
        margin-left: 0;
        border-left-width: 0;
        padding-left: 1px;
        /* replace the border with padding */
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .fc-ltr .fc-h-event.fc-not-end,
    .fc-rtl .fc-h-event.fc-not-start {
        margin-right: 0;
        border-right-width: 0;
        padding-right: 1px;
        /* replace the border with padding */
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    /* resizer (cursor AND touch devices) */
    /* left resizer  */
    .fc-ltr .fc-h-event .fc-start-resizer,
    .fc-rtl .fc-h-event .fc-end-resizer {
        cursor: w-resize;
        left: -1px;
        /* overcome border */
    }

    /* right resizer */
    .fc-ltr .fc-h-event .fc-end-resizer,
    .fc-rtl .fc-h-event .fc-start-resizer {
        cursor: e-resize;
        right: -1px;
        /* overcome border */
    }

    /* resizer (mouse devices) */
    .fc-h-event.fc-allow-mouse-resize .fc-resizer {
        width: 7px;
        top: -1px;
        /* overcome top border */
        bottom: -1px;
        /* overcome bottom border */
    }

    /* resizer (touch devices) */
    .fc-h-event.fc-selected .fc-resizer {
        /* 8x8 little dot */
        border-radius: 4px;
        border-width: 1px;
        width: 6px;
        height: 6px;
        border-style: solid;
        border-color: inherit;
        background: #fff;
        /* vertically center */
        top: 50%;
        margin-top: -4px;
    }

    /* left resizer  */
    .fc-ltr .fc-h-event.fc-selected .fc-start-resizer,
    .fc-rtl .fc-h-event.fc-selected .fc-end-resizer {
        margin-left: -4px;
        /* centers the 8x8 dot on the left edge */
    }

    /* right resizer */
    .fc-ltr .fc-h-event.fc-selected .fc-end-resizer,
    .fc-rtl .fc-h-event.fc-selected .fc-start-resizer {
        margin-right: -4px;
        /* centers the 8x8 dot on the right edge */
    }

    /* DayGrid events
----------------------------------------------------------------------------------------------------
We use the full "fc-day-grid-event" class instead of using descendants because the event won't
be a descendant of the grid when it is being dragged.
*/
    .fc-day-grid-event {
        margin: 1px 2px 0;
        /* spacing between events and edges */
        padding: 0;
    }

    tr:first-child>td>.fc-day-grid-event {
        margin-top: 2px;
        /* a little bit more space before the first event */
    }

    .fc-day-grid-event.fc-selected:after {
        content: "";
        position: absolute;
        z-index: 1;
        /* same z-index as fc-bg, behind text */
        /* overcome the borders */
        top: -1px;
        right: -1px;
        bottom: -1px;
        left: -1px;
        /* darkening effect */
        background: #000;
        opacity: .25;
    }

    .fc-day-grid-event .fc-content {
        /* force events to be one-line tall */
        white-space: nowrap;
        overflow: hidden;
    }

    .fc-day-grid-event .fc-time {
        font-weight: bold;
    }

    /* resizer (cursor devices) */
    /* left resizer  */
    .fc-ltr .fc-day-grid-event.fc-allow-mouse-resize .fc-start-resizer,
    .fc-rtl .fc-day-grid-event.fc-allow-mouse-resize .fc-end-resizer {
        margin-left: -2px;
        /* to the day cell's edge */
    }

    /* right resizer */
    .fc-ltr .fc-day-grid-event.fc-allow-mouse-resize .fc-end-resizer,
    .fc-rtl .fc-day-grid-event.fc-allow-mouse-resize .fc-start-resizer {
        margin-right: -2px;
        /* to the day cell's edge */
    }

    /* Event Limiting
--------------------------------------------------------------------------------------------------*/
    /* "more" link that represents hidden events */
    a.fc-more {
        margin: 1px 3px;
        font-size: .85em;
        cursor: pointer;
        text-decoration: none;
    }

    a.fc-more:hover {
        text-decoration: underline;
    }

    .fc-limited {
        /* rows and cells that are hidden because of a "more" link */
        display: none;
    }

    /* popover that appears when "more" link is clicked */
    .fc-day-grid .fc-row {
        z-index: 1;
        /* make the "more" popover one higher than this */
    }

    .fc-more-popover {
        z-index: 2;
        width: 220px;
    }

    .fc-more-popover .fc-event-container {
        padding: 10px;
    }

    /* Now Indicator
--------------------------------------------------------------------------------------------------*/
    .fc-now-indicator {
        position: absolute;
        border: 0 solid red;
    }

    /* Utilities
--------------------------------------------------------------------------------------------------*/
    .fc-unselectable {
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        -webkit-touch-callout: none;
        -webkit-tap-highlight-color: transparent;
    }

    /*
TODO: more distinction between this file and common.css
*/
    /* Colors
--------------------------------------------------------------------------------------------------*/
    .fc-unthemed th,
    .fc-unthemed td,
    .fc-unthemed thead,
    .fc-unthemed tbody,
    .fc-unthemed .fc-divider,
    .fc-unthemed .fc-row,
    .fc-unthemed .fc-content,
    .fc-unthemed .fc-popover,
    .fc-unthemed .fc-list-view,
    .fc-unthemed .fc-list-heading td {
        border-color: #ddd;
    }

    .fc-unthemed .fc-popover {
        background-color: #fff;
    }

    .fc-unthemed .fc-divider,
    .fc-unthemed .fc-popover .fc-header,
    .fc-unthemed .fc-list-heading td {
        background: #eee;
    }

    .fc-unthemed .fc-popover .fc-header .fc-close {
        color: #666;
    }

    .fc-unthemed td.fc-today {
        background: #fcf8e3;
    }

    .fc-unthemed .fc-disabled-day {
        background: #d7d7d7;
        opacity: .3;
    }

    /* Icons (inline elements with styled text that mock arrow icons)
--------------------------------------------------------------------------------------------------*/
    .fc-icon {
        display: inline-block;
        height: 1em;
        line-height: 1em;
        font-size: 1em;
        text-align: center;
        overflow: hidden;
        font-family: "Courier New", Courier, monospace;
        /* don't allow browser text-selection */
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /*
Acceptable font-family overrides for individual icons:
  "Arial", sans-serif
  "Times New Roman", serif

NOTE: use percentage font sizes or else old IE chokes
*/
    .fc-icon:after {
        position: relative;
    }

    .fc-icon-left-single-arrow:after {
        content: "\2039";
        font-weight: bold;
        font-size: 200%;
        top: -7%;
    }

    .fc-icon-right-single-arrow:after {
        content: "\203A";
        font-weight: bold;
        font-size: 200%;
        top: -7%;
    }

    .fc-icon-left-double-arrow:after {
        content: "\AB";
        font-size: 160%;
        top: -7%;
    }

    .fc-icon-right-double-arrow:after {
        content: "\BB";
        font-size: 160%;
        top: -7%;
    }

    .fc-icon-left-triangle:after {
        content: "\25C4";
        font-size: 125%;
        top: 3%;
    }

    .fc-icon-right-triangle:after {
        content: "\25BA";
        font-size: 125%;
        top: 3%;
    }

    .fc-icon-down-triangle:after {
        content: "\25BC";
        font-size: 125%;
        top: 2%;
    }

    .fc-icon-x:after {
        content: "\D7";
        font-size: 200%;
        top: 6%;
    }

    /* Popover
--------------------------------------------------------------------------------------------------*/
    .fc-unthemed .fc-popover {
        border-width: 1px;
        border-style: solid;
    }

    .fc-unthemed .fc-popover .fc-header .fc-close {
        font-size: .9em;
        margin-top: 2px;
    }

    /* List View
--------------------------------------------------------------------------------------------------*/
    .fc-unthemed .fc-list-item:hover td {
        background-color: #f5f5f5;
    }

    /* Colors
--------------------------------------------------------------------------------------------------*/
    .ui-widget .fc-disabled-day {
        background-image: none;
    }

    /* Popover
--------------------------------------------------------------------------------------------------*/
    .fc-popover>.ui-widget-header+.ui-widget-content {
        border-top: 0;
        /* where they meet, let the header have the border */
    }

    /* Global Event Styles
--------------------------------------------------------------------------------------------------*/
    .ui-widget .fc-event {
        /* overpower jqui's styles on <a> tags. TODO: more DRY */
        color: #fff;
        /* default TEXT color */
        text-decoration: none;
        /* if <a> has an href */
        /* undo ui-widget-header bold */
        font-weight: normal;
    }

    /* TimeGrid axis running down the side (for both the all-day area and the slot area)
--------------------------------------------------------------------------------------------------*/
    .ui-widget td.fc-axis {
        font-weight: normal;
        /* overcome bold */
    }

    /* TimeGrid Slats (lines that run horizontally)
--------------------------------------------------------------------------------------------------*/
    .fc-time-grid .fc-slats .ui-widget-content {
        background: none;
        /* see through to fc-bg */
    }

    .fc.fc-bootstrap3 a {
        text-decoration: none;
    }

    .fc.fc-bootstrap3 a[data-goto]:hover {
        text-decoration: underline;
    }

    .fc-bootstrap3 hr.fc-divider {
        border-color: inherit;
    }

    .fc-bootstrap3 .fc-today.alert {
        border-radius: 0;
    }

    /* Popover
--------------------------------------------------------------------------------------------------*/
    .fc-bootstrap3 .fc-popover .panel-body {
        padding: 0;
    }

    /* TimeGrid Slats (lines that run horizontally)
--------------------------------------------------------------------------------------------------*/
    .fc-bootstrap3 .fc-time-grid .fc-slats table {
        /* some themes have background color. see through to slats */
        background: none;
    }

    .fc.fc-bootstrap4 a {
        text-decoration: none;
    }

    .fc.fc-bootstrap4 a[data-goto]:hover {
        text-decoration: underline;
    }

    .fc-bootstrap4 hr.fc-divider {
        border-color: inherit;
    }

    .fc-bootstrap4 .fc-today.alert {
        border-radius: 0;
    }

    .fc-bootstrap4 a.fc-event:not([href]):not([tabindex]) {
        color: #5d5386;
    }

    .fc-bootstrap4 .fc-popover.card {
        position: absolute;
    }

    /* Popover
--------------------------------------------------------------------------------------------------*/
    .fc-bootstrap4 .fc-popover .card-body {
        padding: 0;
    }

    /* TimeGrid Slats (lines that run horizontally)
--------------------------------------------------------------------------------------------------*/
    .fc-bootstrap4 .fc-time-grid .fc-slats table {
        /* some themes have background color. see through to slats */
        background: none;
    }

    /* Toolbar
--------------------------------------------------------------------------------------------------*/
    .fc-toolbar {
        text-align: center;
    }

    .fc-toolbar.fc-header-toolbar {
        margin-bottom: 1em;
    }

    .fc-toolbar.fc-footer-toolbar {
        margin-top: 1em;
    }

    .fc-toolbar .fc-left {
        float: left;
    }

    .fc-toolbar .fc-right {
        float: right;
    }

    .fc-toolbar .fc-center {
        display: inline-block;
    }

    .fc button {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        margin: 0;
        height: auto;
        padding: 0 1rem;
        font-size: 1rem;
        white-space: nowrap;
        cursor: pointer;
    }

    /* the things within each left/right/center section */
    .fc .fc-toolbar>*>* {
        /* extra precedence to override button border margins */
        float: left;
        margin-left: .75em;
    }

    /* the first thing within each left/center/right section */
    .fc .fc-toolbar>*> :first-child {
        /* extra precedence to override button border margins */
        margin-left: 0;
    }

    /* title text */
    .fc-toolbar h2 {
        margin: 0;
        font-size: 15px;
        font-weight: 700;
    }

    /* button layering (for border precedence) */
    .fc-toolbar button {
        position: relative;
    }

    .fc-toolbar .fc-state-hover,
    .fc-toolbar .ui-state-hover {
        z-index: 2;
    }

    .fc-toolbar .fc-state-down {
        z-index: 3;
    }

    .fc-toolbar .fc-state-active,
    .fc-toolbar .ui-state-active {
        z-index: 4;
    }

    .fc-toolbar button:focus {
        z-index: 5;
    }

    /* View Structure
--------------------------------------------------------------------------------------------------*/
    /* undo twitter bootstrap's box-sizing rules. normalizes positioning techniques */
    /* don't do this for the toolbar because we'll want bootstrap to style those buttons as some pt */
    .fc-view-container *,
    .fc-view-container *:before,
    .fc-view-container *:after {
        -webkit-box-sizing: content-box;
        -moz-box-sizing: content-box;
        box-sizing: content-box;
    }

    .fc-view,
    .fc-view>table {
        /* so dragged elements can be above the view's main element */
        position: relative;
        z-index: 1;
    }

    /* BasicView
--------------------------------------------------------------------------------------------------*/
    /* day row structure */
    .fc-basicWeek-view .fc-content-skeleton,
    .fc-basicDay-view .fc-content-skeleton {
        /* there may be week numbers in these views, so no padding-top */
        padding-bottom: 1em;
        /* ensure a space at bottom of cell for user selecting/clicking */
    }

    .fc-basic-view .fc-body .fc-row {
        min-height: 4em;
        /* ensure that all rows are at least this tall */
    }

    /* a "rigid" row will take up a constant amount of height because content-skeleton is absolute */
    .fc-row.fc-rigid {
        overflow: hidden;
    }

    .fc-row.fc-rigid .fc-content-skeleton {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
    }

    /* week and day number styling */
    .fc-day-top.fc-other-month {
        opacity: 0.3;
    }

    .fc-basic-view .fc-week-number,
    .fc-basic-view .fc-day-number {
        padding: 2px;
        color: rgba(52, 40, 104, .8);
        font-size: 15px;
        font-weight: 400;
    }

    .fc-basic-view th.fc-week-number,
    .fc-basic-view th.fc-day-number {
        padding: 0 2px;
        /* column headers can't have as much v space */
    }

    .fc-ltr .fc-basic-view .fc-day-top .fc-day-number {
        float: right;
    }

    .fc-rtl .fc-basic-view .fc-day-top .fc-day-number {
        float: left;
    }

    .fc-ltr .fc-basic-view .fc-day-top .fc-week-number {
        float: left;
        border-radius: 0 0 3px 0;
    }

    .fc-rtl .fc-basic-view .fc-day-top .fc-week-number {
        float: right;
        border-radius: 0 0 0 3px;
    }

    .fc-basic-view .fc-day-top .fc-week-number {
        min-width: 1.5em;
        text-align: center;
        background-color: #f2f2f2;
        color: #808080;
    }

    /* when week/day number have own column */
    .fc-basic-view td.fc-week-number {
        text-align: center;
    }

    .fc-basic-view td.fc-week-number>* {
        /* work around the way we do column resizing and ensure a minimum width */
        display: inline-block;
        min-width: 1.25em;
    }

    /* AgendaView all-day area
--------------------------------------------------------------------------------------------------*/
    .fc-agenda-view .fc-day-grid {
        position: relative;
        z-index: 2;
        /* so the "more.." popover will be over the time grid */
    }

    .fc-agenda-view .fc-day-grid .fc-row {
        min-height: 3em;
        /* all-day section will never get shorter than this */
    }

    .fc-agenda-view .fc-day-grid .fc-row .fc-content-skeleton {
        padding-bottom: 1em;
        /* give space underneath events for clicking/selecting days */
    }

    /* TimeGrid axis running down the side (for both the all-day area and the slot area)
--------------------------------------------------------------------------------------------------*/
    .fc .fc-axis {
        /* .fc to overcome default cell styles */
        vertical-align: middle;
        padding: 0 4px;
        white-space: nowrap;
    }

    .fc-ltr .fc-axis {
        text-align: right;
    }

    .fc-rtl .fc-axis {
        text-align: left;
    }

    /* TimeGrid Structure
--------------------------------------------------------------------------------------------------*/
    .fc-time-grid-container,
    .fc-time-grid {
        /* so slats/bg/content/etc positions get scoped within here */
        position: relative;
        z-index: 1;
    }

    .fc-time-grid {
        min-height: 100%;
        /* so if height setting is 'auto', .fc-bg stretches to fill height */
    }

    .fc-time-grid table {
        /* don't put outer borders on slats/bg/content/etc */
        border: 0 hidden transparent;
    }

    .fc-time-grid>.fc-bg {
        z-index: 1;
        background: #fff;
    }

    .fc-time-grid .fc-slats,
    .fc-time-grid>hr {
        /* the <hr> AgendaView injects when grid is shorter than scroller */
        position: relative;
        z-index: 2;
    }

    .fc-time-grid .fc-content-col {
        position: relative;
        /* because now-indicator lives directly inside */
    }

    .fc-time-grid .fc-content-skeleton {
        position: absolute;
        z-index: 3;
        top: 0;
        left: 0;
        right: 0;
    }

    /* divs within a cell within the fc-content-skeleton */
    .fc-time-grid .fc-business-container {
        position: relative;
        z-index: 1;
    }

    .fc-time-grid .fc-bgevent-container {
        position: relative;
        z-index: 2;
    }

    .fc-time-grid .fc-highlight-container {
        position: relative;
        z-index: 3;
    }

    .fc-time-grid .fc-event-container {
        position: relative;
        z-index: 4;
    }

    .fc-time-grid .fc-now-indicator-line {
        z-index: 5;
    }

    .fc-time-grid .fc-helper-container {
        /* also is fc-event-container */
        position: relative;
        z-index: 6;
    }

    /* TimeGrid Slats (lines that run horizontally)
--------------------------------------------------------------------------------------------------*/
    .fc-time-grid .fc-slats td {
        height: 1.5em;
        border-bottom: 0;
        padding: 10px;
        /* each cell is responsible for its top border */
    }

    .fc-agendaDay-view .fc-time-grid .fc-slats td {
        background: #ffffff;
    }

    .fc-time-grid .fc-slats .fc-minor td {
        border-top-style: dotted;
    }

    /* TimeGrid Highlighting Slots
--------------------------------------------------------------------------------------------------*/
    .fc-time-grid .fc-highlight-container {
        /* a div within a cell within the fc-highlight-skeleton */
        position: relative;
        /* scopes the left/right of the fc-highlight to be in the column */
    }

    .fc-time-grid .fc-highlight {
        position: absolute;
        left: 0;
        right: 0;
        /* top and bottom will be in by JS */
    }

    /* TimeGrid Event Containment
--------------------------------------------------------------------------------------------------*/
    .fc-ltr .fc-time-grid .fc-event-container {
        /* space on the sides of events for LTR (default) */
        margin: 0 2.5% 0 2px;
    }

    .fc-rtl .fc-time-grid .fc-event-container {
        /* space on the sides of events for RTL */
        margin: 0 2px 0 2.5%;
    }

    .fc-time-grid .fc-event,
    .fc-time-grid .fc-bgevent {
        position: absolute;
        z-index: 1;
        /* scope inner z-index's */
    }

    .fc-time-grid .fc-bgevent {
        /* background events always span full width */
        left: 0;
        right: 0;
    }

    /* Generic Vertical Event
--------------------------------------------------------------------------------------------------*/
    .fc-v-event.fc-not-start {
        /* events that are continuing from another day */
        /* replace space made by the top border with padding */
        border-top-width: 0;
        padding-top: 1px;
        /* remove top rounded corners */
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    .fc-v-event.fc-not-end {
        /* replace space made by the top border with padding */
        border-bottom-width: 0;
        padding-bottom: 1px;
        /* remove bottom rounded corners */
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }

    /* TimeGrid Event Styling
----------------------------------------------------------------------------------------------------
We use the full "fc-time-grid-event" class instead of using descendants because the event won't
be a descendant of the grid when it is being dragged.
*/
    .fc-time-grid-event {
        overflow: hidden;
        /* don't let the bg flow over rounded corners */
    }

    .fc-time-grid-event.fc-selected {
        /* need to allow touch resizers to extend outside event's bounding box */
        /* common fc-selected styles hide the fc-bg, so don't need this anyway */
        overflow: visible;
    }

    .fc-time-grid-event.fc-selected .fc-bg {
        display: none;
        /* hide semi-white background, to appear darker */
    }

    .fc-time-grid-event .fc-content {
        overflow: hidden;
        /* for when .fc-selected */
    }

    .fc-time-grid-event .fc-time,
    .fc-time-grid-event .fc-title {
        padding: 0 1px;
    }

    .fc-time-grid-event .fc-time {
        font-size: .85em;
        white-space: nowrap;
    }

    /* short mode, where time and title are on the same line */
    .fc-time-grid-event.fc-short .fc-content {
        /* don't wrap to second line (now that contents will be inline) */
        white-space: nowrap;
    }

    .fc-time-grid-event.fc-short .fc-time,
    .fc-time-grid-event.fc-short .fc-title {
        /* put the time and title on the same line */
        display: inline-block;
        vertical-align: top;
    }

    .fc-time-grid-event.fc-short .fc-time span {
        display: none;
        /* don't display the full time text... */
    }

    .fc-time-grid-event.fc-short .fc-time:before {
        content: attr(data-start);
        /* ...instead, display only the start time */
    }

    .fc-time-grid-event.fc-short .fc-time:after {
        content: "\A0-\A0";
        /* seperate with a dash, wrapped in nbsp's */
    }

    .fc-time-grid-event.fc-short .fc-title {
        font-size: .85em;
        /* make the title text the same size as the time */
        padding: 0;
        /* undo padding from above */
    }

    /* resizer (cursor device) */
    .fc-time-grid-event.fc-allow-mouse-resize .fc-resizer {
        left: 0;
        right: 0;
        bottom: 0;
        height: 8px;
        overflow: hidden;
        line-height: 8px;
        font-size: 11px;
        font-family: monospace;
        text-align: center;
        cursor: s-resize;
    }

    .fc-time-grid-event.fc-allow-mouse-resize .fc-resizer:after {
        content: "=";
    }

    /* resizer (touch device) */
    .fc-time-grid-event.fc-selected .fc-resizer {
        /* 10x10 dot */
        border-radius: 5px;
        border-width: 1px;
        width: 8px;
        height: 8px;
        border-style: solid;
        border-color: inherit;
        background: #fff;
        /* horizontally center */
        left: 50%;
        margin-left: -5px;
        /* center on the bottom edge */
        bottom: -5px;
    }

    /* Now Indicator
--------------------------------------------------------------------------------------------------*/
    .fc-time-grid .fc-now-indicator-line {
        border-top-width: 1px;
        left: 0;
        right: 0;
    }

    /* arrow on axis */
    .fc-time-grid .fc-now-indicator-arrow {
        margin-top: -5px;
        /* vertically center on top coordinate */
    }

    .fc-ltr .fc-time-grid .fc-now-indicator-arrow {
        left: 0;
        /* triangle pointing right... */
        border-width: 5px 0 5px 6px;
        border-top-color: transparent;
        border-bottom-color: transparent;
    }

    .fc-rtl .fc-time-grid .fc-now-indicator-arrow {
        right: 0;
        /* triangle pointing left... */
        border-width: 5px 6px 5px 0;
        border-top-color: transparent;
        border-bottom-color: transparent;
    }

    /* List View
--------------------------------------------------------------------------------------------------*/
    /* possibly reusable */
    .fc-event-dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 5px;
    }

    /* view wrapper */
    .fc-rtl .fc-list-view {
        direction: rtl;
        /* unlike core views, leverage browser RTL */
    }

    .fc-list-view {
        border-width: 1px;
        border-style: solid;
    }

    /* table resets */
    .fc .fc-list-table {
        table-layout: auto;
        /* for shrinkwrapping cell content */
    }

    .fc-list-table td {
        border-width: 1px 0 0;
        padding: 8px 14px;
    }

    .fc-list-table tr:first-child td {
        border-top-width: 0;
    }

    /* day headings with the list */
    .fc-list-heading {
        border-bottom-width: 1px;
    }

    .fc-list-heading td {
        font-weight: bold;
    }

    .fc-ltr .fc-list-heading-main {
        float: left;
    }

    .fc-ltr .fc-list-heading-alt {
        float: right;
    }

    .fc-rtl .fc-list-heading-main {
        float: right;
    }

    .fc-rtl .fc-list-heading-alt {
        float: left;
    }

    /* event list items */
    .fc-list-item.fc-has-url {
        cursor: pointer;
        /* whole row will be clickable */
    }

    .fc-list-item-marker,
    .fc-list-item-time {
        white-space: nowrap;
        width: 1px;
    }

    /* make the dot closer to the event title */
    .fc-ltr .fc-list-item-marker {
        padding-right: 0;
    }

    .fc-rtl .fc-list-item-marker {
        padding-left: 0;
    }

    .fc-list-item-title a {
        /* every event title cell has an <a> tag */
        text-decoration: none;
        color: inherit;
    }

    .fc-list-item-title a[href]:hover {
        /* hover effect only on titles with hrefs */
        text-decoration: underline;
    }

    /* message when no events */
    .fc-list-empty-wrap2 {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }

    .fc-list-empty-wrap1 {
        width: 100%;
        height: 100%;
        display: table;
    }

    .fc-list-empty {
        display: table-cell;
        vertical-align: middle;
        text-align: center;
    }

    .fc-unthemed .fc-list-empty {
        /* theme will provide own background */
        background-color: #eee;
    }


    .fc th.fc-day-header {
        padding: 11px 7px;
        font-size: 16px;
        font-weight: 400;
    }

    .fc-day.fc-today {
        background: rgba(52, 40, 104, .03);
    }

    .fc-day.alert-info {
        background: rgba(52, 40, 104, .03);
    }

    .datepicker {
        z-index: 123456;
    }

    body {
        font-family: 'Nunito', sans-serif;
        background: #F3F5F9;
    }

    .card {
        border: 0;
        background: transparent;
    }

    h2 {
        text-transform: uppercase;
        font-weight: 700;
        font-size: 22px;
        text-align: center;
        letter-spacing: 1px;
        font-family: 'Montserrat', sans-serif;
        color: #002147;
        margin-bottom: 20px;
    }

    .btn {
        font-size: 15px !important;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 2.5px;
        font-family: 'Nunito', sans-serif;
        box-shadow: none !important;
        border: 0;
        padding: 10px 20px !important;
    }

    .btn:focus {
        box-shadow: none;
    }

    .btn.btn-primary {
        background: #002147;
        color: #ffffff;
    }

    .form-group label {
        font-weight: 600;
        letter-spacing: 0.010em;
        font-size: 18px;
        margin-bottom: 5px;
    }

    .modal-body {
        background: #F3F5F9;
        border-radius: 10px;
    }

    .modal-body h4 {
        text-transform: uppercase;
        font-weight: 700;
        font-size: 18px;
        letter-spacing: 1px;
        font-family: 'Montserrat', sans-serif;
        color: #002147;
        margin-bottom: 20px;
    }

    .modal-body .form-control {
        box-shadow: none;
        height: 50px;
    }


    /* related product */
    .related-product {
        padding: 80px 0;
    }

    .related-product .container {
        max-width: 1200px;
        width: 100%;
        margin: 0 auto;
    }

    .related-product ul {
        padding: 0;
        margin: 0;
    }

    .related-product ul li {
        margin-bottom: 30px;
        list-style-type: none;
    }

    .related-product ul li h3 {
        font-weight: 700;
        font-size: 24px;
        padding: 20px 0;
    }

    .related-product ul li a {
        font-weight: 600;
        color: #3b484a;
        text-align: center;
    }

    .related-product ul li a img {
        max-width: 100%;
        display: block;
    }

    .related-box {
        max-width: 400px;
        margin: 0 auto;
    }

    .related-box.related-box-iframe {
        max-width: 100%;
    }

    .download-btn {
        padding: 15px;
        display: inline-flex;
        align-items: center;
    }

    .download-btn .fa {
        font-size: 40px;
        margin-right: 10px;
    }
</style>

<script>
    jQuery(document).ready(function() {
        jQuery('.datetimepicker').datepicker({
            timepicker: true,
            language: 'en',
            range: true,
            multipleDates: true,
            multipleDatesSeparator: " - "
        });
        jQuery("#add-event").submit(function() {
            alert("Submitted");
            var values = {};
            $.each($('#add-event').serializeArray(), function(i, field) {
                values[field.name] = field.value;
            });
            console.log(
                values
            );
        });
    });

    (function() {
        'use strict';
        // ------------------------------------------------------- //
        // Calendar
        // ------------------------------------------------------ //
        jQuery(function() {
            // page is ready
            jQuery('#calendar').fullCalendar({
                themeSystem: 'bootstrap4',
                // emphasizes business hours
                businessHours: false,
                defaultView: 'month',
                // event dragging & resizing
                editable: true,
                // header
                header: {
                    left: 'title',
                    // center: 'month,agendaWeek,agendaDay',
                    right: 'today prev,next'
                },
                events: [{
                        title: 'Barber',
                        description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eu pellentesque nibh. In nisl nulla, convallis ac nulla eget, pellentesque pellentesque magna.',
                        start: '2023-05-05',
                        end: '2023-05-05',
                        className: 'fc-bg-default',
                        icon: "circle"
                    },
                    {
                        title: 'Flight Paris',
                        description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eu pellentesque nibh. In nisl nulla, convallis ac nulla eget, pellentesque pellentesque magna.',
                        start: '2023-08-08T14:00:00',
                        end: '2023-08-08T20:00:00',
                        className: 'fc-bg-deepskyblue',
                        icon: "cog",
                        allDay: false
                    },
                    {
                        title: 'Team Meeting',
                        description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eu pellentesque nibh. In nisl nulla, convallis ac nulla eget, pellentesque pellentesque magna.',
                        start: '2023-07-10T13:00:00',
                        end: '2023-07-10T16:00:00',
                        className: 'fc-bg-pinkred',
                        icon: "group",
                        allDay: false
                    },
                    {
                        title: 'Meeting',
                        description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eu pellentesque nibh. In nisl nulla, convallis ac nulla eget, pellentesque pellentesque magna.',
                        start: '2023-08-12',
                        className: 'fc-bg-lightgreen',
                        icon: "suitcase"
                    },
                    {
                        title: 'Conference',
                        description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eu pellentesque nibh. In nisl nulla, convallis ac nulla eget, pellentesque pellentesque magna.',
                        start: '2023-08-13',
                        end: '2023-08-15',
                        className: 'fc-bg-blue',
                        icon: "calendar"
                    },
                    {
                        title: 'Baby Shower',
                        description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eu pellentesque nibh. In nisl nulla, convallis ac nulla eget, pellentesque pellentesque magna.',
                        start: '2023-08-13',
                        end: '2023-08-14',
                        className: 'fc-bg-default',
                        icon: "child"
                    },
                    {
                        title: 'Birthday',
                        description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eu pellentesque nibh. In nisl nulla, convallis ac nulla eget, pellentesque pellentesque magna.',
                        start: '2023-09-13',
                        end: '2023-09-14',
                        className: 'fc-bg-default',
                        icon: "birthday-cake"
                    },
                    {
                        title: 'Restaurant',
                        description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eu pellentesque nibh. In nisl nulla, convallis ac nulla eget, pellentesque pellentesque magna.',
                        start: '2023-10-15T09:30:00',
                        end: '2023-10-15T11:45:00',
                        className: 'fc-bg-default',
                        icon: "glass",
                        allDay: false
                    },
                    {
                        title: 'Dinner',
                        description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eu pellentesque nibh. In nisl nulla, convallis ac nulla eget, pellentesque pellentesque magna.',
                        start: '2023-11-15T20:00:00',
                        end: '2023-11-15T22:30:00',
                        className: 'fc-bg-default',
                        icon: "cutlery",
                        allDay: false
                    },
                    {
                        title: 'Shooting',
                        description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eu pellentesque nibh. In nisl nulla, convallis ac nulla eget, pellentesque pellentesque magna.',
                        start: '2023-08-25',
                        end: '2023-08-25',
                        className: 'fc-bg-blue',
                        icon: "camera"
                    },
                    {
                        title: 'Go Space :)',
                        description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eu pellentesque nibh. In nisl nulla, convallis ac nulla eget, pellentesque pellentesque magna.',
                        start: '2023-12-27',
                        end: '2023-12-27',
                        className: 'fc-bg-default',
                        icon: "rocket"
                    },
                    {
                        title: 'Dentist',
                        description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eu pellentesque nibh. In nisl nulla, convallis ac nulla eget, pellentesque pellentesque magna.',
                        start: '2023-12-29T11:30:00',
                        end: '2023-12-29T012:30:00',
                        className: 'fc-bg-blue',
                        icon: "medkit",
                        allDay: false
                    }
                ],
                eventRender: function(event, element) {
                    if (event.icon) {
                        element.find(".fc-title").prepend("<i class='fa fa-" + event.icon + "'></i>");
                    }
                },
                dayClick: function() {
                    jQuery('#modal-view-event-add').modal();
                },
                eventClick: function(event, jsEvent, view) {
                    jQuery('.event-icon').html("<i class='fa fa-" + event.icon + "'></i>");
                    jQuery('.event-title').html(event.title);
                    jQuery('.event-body').html(event.description);
                    jQuery('.eventUrl').attr('href', event.url);
                    jQuery('#modal-view-event').modal();
                },
            })
        });

    })(jQuery);
</script>

<link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome-font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.js"></script>
