jQuery(document).ready(function ($) {
    const steps = new StepIndicator(".steps");
});

class StepIndicator {
    /**
     * @param el CSS selector of the step indicator element
     */
    constructor(el) {
        /** Number of steps */
        this.steps = 6;
        this._step = 0;
        this.$el = jQuery(el);

        // Bind click events using jQuery to prevent duplication
        jQuery(document).on("click", '[data-action="prev"]', this.prev.bind(this));
        jQuery(document).on("click", '[data-action="next"]', this.next.bind(this));

        this.displayStep(this.step);
        this.checkExtremes();
    }

    get step() {
        return this._step;
    }

    set step(value) {
        this._step = value;
        this.displayStep(value);
        this.checkExtremes();
    }

    /** Go to the previous step. */
    prev() {
        if (this.step > 0) {
            this.step -= 1;
        }
    }

    /** Go to the next step. */
    next() {
        if (this.step < this.steps - 1) {
            this.step += 1;
        }
    }

    /** Disable the Previous or Next button if hitting the first or last step. */
    checkExtremes() {
        const $prevBtn = jQuery('[data-action="prev"]');
        const $nextBtn = jQuery('[data-action="next"]');
        $prevBtn.prop("disabled", this.step <= 0);
        $nextBtn.prop("disabled", this.step >= this.steps - 1);
    }

    /**
     * Update the indicator for a targeted step.
     * @param targetStep Index of the step
     */
    displayStep(targetStep) {
        const currentClass = "steps__step--current";
        const doneClass = "steps__step--done";

        jQuery('.profile-step-forms').removeClass('active');
        jQuery('.profile-step-forms[data-step="' + targetStep + '"]').addClass('active');

        for (let s = 0; s < this.steps; ++s) {
            const $stepEl = this.$el.find(`[data-step="${s}"]`);
            $stepEl.removeClass(`${currentClass} ${doneClass}`);
            jQuery('form[data-step="' + s + '"]').hide();
            if (s < targetStep) {
                $stepEl.addClass(doneClass);
            } else if (s === targetStep) {
                $stepEl.addClass(currentClass);
            }
        }
    }
}
