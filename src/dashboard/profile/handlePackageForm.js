export default function handlePackageForm($) {
  if (WVL_DATA.venue_status === "publish") {
    $(".profile-form-success").html("Your profile has been updated.");
    return true;
  }

  const $form = $("form#packageInfoForm");

  return true;
}
