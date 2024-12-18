import handleContactInfoForm from "./handleContactInfoForm";
import handlePackageForm from "./handlePackageForm";
import handlePersonalInfoForm from "./handlePersonalInfoForm";
import handlePhotographsForm from "./handlePhotographsForm";
import handleServiceInfoForm from "./handleServiceInfoForm";
import handleSubmitForm from "./handleSubmitForm";
import handleVideoForm from "./handleVideoForm";
import handleYourStoryForm from "./handleYourStoryForm";
import StepIndicator from "./stepIndicator";

jQuery(document).ready(function ($) {
  if (typeof tinymce !== "undefined") {
    tinymce.init({
      selector: "#yourStory", // Target the textarea
      menubar: false, // Hide the menu bar
      toolbar:
        "bold italic underline | alignleft aligncenter alignright | bullist numlist | link", // Custom toolbar
      plugins: "lists link", // Load required plugins
      height: 300,
    });
  }

  handlePhotographsForm($);
  handleVideoForm($);

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
    } else if (step === 6) {
      return await handleSubmitForm($);
    }

    return false;
  }

  const url = new URL(window.location.href);
  const currentStep = url.searchParams.get("step");
  let indicator;
  if (currentStep) {
    indicator = new StepIndicator(".steps", handleNext, parseInt(currentStep));
  } else {
    indicator = new StepIndicator(".steps", handleNext);
  }

  window.addEventListener("popstate", function (event) {
    indicator.prev();
  });
});
