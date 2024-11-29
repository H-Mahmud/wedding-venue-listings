import handleGalleryUpload from "./handleGalleryUpload";
import handleProfileInfoForm from "./handleProfileInfoForm";
import handleProfilePhotographsForm from "./handleProfilePhotographsForm";
import handleServiceInfoForm from "./handleServiceInfoForm";
import handleYourStoryForm from "./handleYourStory";

jQuery(document).ready(function ($) {


    async function handleNext(step) {
        if (step === 0) {
            return await handleProfileInfoForm();
        } else if (step === 1) {
            return await handleServiceInfoForm($);
        } else if (step === 3) {
            return await handleYourStoryForm();
        } else if (step === 4) {
            return await handleProfilePhotographsForm($);
        }

        return true;
    }

    handleGalleryUpload($);

    const steps = new StepIndicator(".steps", handleNext, 1);
});

class StepIndicator {
    /**
     * @param el CSS selector of the step indicator element
     */
    constructor(el, handleNext = async () => { }, currentStep = 0) {
        this.steps = 6;
        this._step = currentStep;
        this.$el = jQuery(el);
        this.handleNext = handleNext;

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
    async next() {
        if (! await this.handleNext(this.step)) return;
        if (this.step < this.steps - 1) {
            this.step += 1;
        }
    }

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
    }    /** Disable the Previous or Next button if hitting the first or last step. */
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

}
