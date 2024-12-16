// import './style.css';
import './style.scss';

(function ($) {
    $(document).ready(function () {
      // Open Modal
      function openModal(modal) {
        $(modal).attr('aria-hidden', 'false').fadeIn();
        $(modal).focus();
      }
  
      // Close Modal
      function closeModal(modal) {
        $(modal).attr('aria-hidden', 'true').fadeOut();
      }
  
      // Handle click on open modal buttons
      $('.open-modal-btn').on('click', function (e) {
        e.preventDefault();
        const targetModal = $(this).data('target');
        openModal(targetModal);
      });
  
      // Handle close button and cancel button
      $('.wvl-modal').on('click', '.close-btn, .cancel-btn', function () {
        const modal = $(this).closest('.wvl-modal');
        closeModal(modal);
      });
  
      // Close modal when clicking outside modal-inner
      $('.wvl-modal').on('click', function (e) {
        if ($(e.target).is('.wvl-modal')) {
          closeModal(this);
        }
      });
  
      // Close modal with Escape key
      $(document).on('keydown', function (e) {
        if (e.key === 'Escape') {
          $('.wvl-modal[aria-hidden="false"]').each(function () {
            closeModal(this);
          });
        }
      });
    });
  })(jQuery);
  