function prepopulateValues(payment, billingData, prepBool) {
    if(prepBool == 1){
        document.getElementById('editBillingId').value = billingData.billRefNo;
        document.getElementById('editTenantName').value = billingData.full_name;

        document.getElementById('editBillDateIssued').value = billingData.billDateIssued;
        document.getElementById('editBillDateIssuedDummy').value = billingData.billDateIssued;
        
        document.getElementById('editBillDueDate').value = billingData.billDueDate;
        document.getElementById('editBillDueDateDummy').value = billingData.billDueDate;
        
        
        document.getElementById('edit-create-billing-billTotal').value = billingData.billTotal
    } else {
        document.getElementById('editPaidBillingId').value = billingData.billRefNo;
        
        document.getElementById('editPaidTenantName').value = billingData.full_name;
        document.getElementById('editPaidBillDueDate').value = billingData.billDueDate;
        document.getElementById('edit-datePaid').value = payment[0].payDate;
        document.getElementById('editPaidBillTotal').value = payment[0].payAmnt;
        document.getElementById('edit-payer-fname').value = payment[0].payerFname;
        document.getElementById('edit-payer-lname').value = payment[0].payerLname;
        document.getElementById('edit-payer-MI').value = payment[0].payerMI;
        console.log(payment[0].payAmnt);
    }
}

function prepopulatePayment(billingData){
    document.getElementById('paymentTenantName').value = billingData.full_name;
    document.getElementById('paymentBillDueDate').value = billingData.billDueDate;
    document.getElementById('paymentAmount').value = billingData.billTotal;
    document.getElementById('actualPaymentAmount').value = billingData.billTotal;
    document.getElementById('paymentTenantID').value = billingData.tenID;
    document.getElementById('billRefNo').value = billingData.billRefNo;
}
