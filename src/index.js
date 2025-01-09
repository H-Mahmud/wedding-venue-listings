// Components
import "./components/calendar";
import "./components/star-rating";
import "./components/modal";
import "./styles/elementor-pricing-table";

// Styles
import "./globals.scss";
import "./dashboard/dashboard-style.scss";
import "./styles/forms.css";
import "./styles/listing-page.scss";
import "./styles/single-venue.scss";
import "./styles/listing-list.scss";

jQuery(document).ready(function ($) {
  const tabs = $(".tabs");
  if (tabs.length === 0) {
    return;
  }

  const tabsOffset = tabs.offset()?.top || 0;

  function handleStickyTabs() {
    const scrollTop = $(window).scrollTop();
    const parentWidth = $(".tabs").parent().outerWidth(); // Get parent width

    if (scrollTop >= tabsOffset) {
      $(".tabs").addClass("sticky").css("width", parentWidth); // Set width dynamically
    } else {
      $(".tabs").removeClass("sticky").css("width", ""); // Reset width
    }
  }

  // Function to update the active tab
  function updateActiveTab() {
    const scrollPosition = $(window).scrollTop();
    $(".section").each(function () {
      const sectionTop = $(this).offset()?.top - tabs.outerHeight();
      const sectionBottom = sectionTop + $(this).outerHeight();
      const id = $(this).attr("id");

      if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) {
        $(".tab").removeClass("active");
        $(`.tab[data-target="#${id}"]`).addClass("active");
      }
    });
  }

  // Handle tab click
  $(".tab").on("click", function () {
    const target = $($(this).data("target"));
    if (target.length) {
      $("html, body").animate(
        {
          scrollTop: target.offset().top - tabs.outerHeight(),
        },
        500,
      );
    }
  });

  // Update sticky and active tab on scroll
  $(window).on("scroll", function () {
    handleStickyTabs();
    updateActiveTab();
  });

  // Initial setup
  handleStickyTabs();
  updateActiveTab();
});
