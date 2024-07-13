const amountCalculator = (applianceRate) => {
    const payOccType = document.getElementById('payment-occupancyType');
    const noOfAppliances = document.getElementById('noOfAppliances');
    // const applianceRate = parseInt(document.getElementById('applianceRate').value);
    const totalAmountPayment = document.getElementById('dummy-create-billing-billTotal');
    const actualAmountPayment = document.getElementById('create-billing-billTotal');

    const payOccTypeValue = parseInt(payOccType.value, 10);
    const noOfAppliancesValue = parseInt(noOfAppliances.value, 10);
    
    totalAmountPayment.value = payOccTypeValue + noOfAppliancesValue * applianceRate;
    actualAmountPayment.value = payOccTypeValue + noOfAppliancesValue * applianceRate;
};

amountCalculator();
