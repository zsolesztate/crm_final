export const dateWatcher = (form, availableContacts, fetchAvailableContacts, errorMessage,selectedContact = () => {}) => {
    const fromDate = form.start_date;
    const toDate = form.finnish_date;

    if (!fromDate || !toDate) {
        errorMessage.value = '';
        return;
    }

    if (fromDate === toDate) {
        errorMessage.value = 'A két dátum nem lehet azonos.';
        availableContacts.value = []
        return;
    }

    if (new Date(fromDate) > new Date(toDate)) {
        errorMessage.value = 'A kezdés dátuma nem lehet későbbi a befejezés dátumánál.';
        availableContacts.value = []
        return;
    }

    if (new Date(toDate) < new Date(fromDate)) {
        errorMessage.value = 'A befejezés dátuma nem lehet korábbi a kezdés dátumánál.';
        availableContacts.value = []
        return;
    }

    errorMessage.value = '';
    fetchAvailableContacts();
    selectedContact();
};
