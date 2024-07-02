
function prepopulateValues(billingId, tenantId, billTotal, billDateIssued, billDueDate, isPaid) {
    // Populate hidden billing ID
    document.getElementById('editBillingId').value = billingId;

    // Populate tenant select dropdown
    document.getElementById('editTenantName').value = tenantId;

    // Populate other fields
    document.getElementById('editBillTotal').value = billTotal;
    document.getElementById('editBillDateIssued').value = billDateIssued;
    document.getElementById('editBillDueDate').value = billDueDate;

    // Populate status dropdown
    document.getElementById('editStatusPayment').value = isPaid; // Assuming isPaid is a boolean or 0/1 value

    console.log('Values prepopulated successfully!');
    console.log('Billing ID:', billingId);
    console.log('Tenant ID:', tenantId);
    console.log('Bill Total:', billTotal);
    console.log('Bill Date Issued:', billDateIssued);
    console.log('Bill Due Date:', billDueDate);
    console.log('Is Paid:', isPaid);
}
