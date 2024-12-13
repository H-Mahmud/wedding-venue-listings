import handleContactInfoForm from './handleContactInfoForm';
import handlePackageForm from './handlePackageForm';
import handlePersonalInfoForm from './handlePersonalInfoForm';
import handlePhotographsForm from './handlePhotographsForm';
import handleServiceInfoForm from './handleServiceInfoForm';
import handleSubmitForm from './handleSubmitForm';
import handleYourStoryForm from './handleYourStoryForm';

jQuery(document).ready(function ($) {
    handlePhotographsForm($);

    async function handleNext(step) {
        if (step === 0) {
            return await handlePackageForm($);
        } else if (step === 1) {
            return await handlePersonalInfoForm($);
        } else if (step === 2) {
            return await handleServiceInfoForm($);
        } else if (step === 3) {
            return await handleContactInfoForm($);
        } else if (step === 4) {
            return await handleYourStoryForm($);
        } else if (step === 5) {
            return await handleSubmitForm($);
        }

        return false;
    }

    const url = new URL(window.location.href);
    const currentStep = url.searchParams.get("step");
    let indicator
    if (currentStep) {
        indicator = new StepIndicator(".steps", handleNext, parseInt(currentStep));
    } else {
        indicator = new StepIndicator(".steps", handleNext);
    }

    window.addEventListener('popstate', function (event) {
        indicator.prev();
    });

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

            const url = new URL(window.location.href);
            url.searchParams.set("step", this.step);
            window.history.pushState({}, '', url.href)
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
        if (WVL_DATA.venue_status === 'publish') {
            $nextBtn.html(this.step >= this.steps - 1 ? 'Save' : 'Next');
            // $nextBtn.prop("disabled", this.step >= this.steps - 1);
        } else if (WVL_DATA.venue_status === 'pending') {
            $nextBtn.prop("disabled", this.step >= this.steps - 1);
            $nextBtn.html(this.step >= this.steps - 1 ? 'Submitted' : 'Next');
        } else {
            $nextBtn.html(this.step >= this.steps - 1 ? 'Request to Publish' : 'Next');
        }
    }

}


