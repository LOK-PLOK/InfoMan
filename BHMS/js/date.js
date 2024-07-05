function calculateDate(startDateID, dummyEndDateID, endDateID) {
    console.log(startDateID);
    document.getElementById(startDateID).addEventListener('change', function() {
        const startDate = new Date(this.value);
        
        if (!isNaN(startDate.getTime())) {
            const endDate = new Date(startDate);
            endDate.setDate(endDate.getDate() + 30);
            
            const endDateString = endDate.toISOString().split('T')[0];
            document.getElementById(endDateID).value = endDateString;
            document.getElementById(dummyEndDateID).value = endDateString;
        } else {
            console.log('Invalid start date');
        }
    });
}