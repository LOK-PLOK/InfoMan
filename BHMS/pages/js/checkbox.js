// Non-tenant checkbox modal expand functionality
document.addEventListener('DOMContentLoaded', function() {
    const checkbox = document.querySelector('#non-tenant-check');
    const payerDetails = document.querySelector('.payer-details');
    const payerInputs = payerDetails.querySelectorAll('input');
  
    payerInputs.forEach(input => input.setAttribute('disabled', 'disabled'));
  
    checkbox.addEventListener('change', function() {
      if (checkbox.checked) {
        payerDetails.style.display = 'block';
        payerInputs.forEach(input => input.removeAttribute('disabled'));
      } else {
        payerDetails.style.display = 'none';
        payerInputs.forEach(input => input.setAttribute('disabled', 'disabled'));
      }
    });
  });
  