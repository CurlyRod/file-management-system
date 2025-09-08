function searchUtility(tableName, inputName, paginate = "#pagination") {

    $(document).off('keydown', inputName);
    $(document).off('keyup', inputName);

    // Prevent Enter key from submitting the for .. rod
    $(document).on('keydown', inputName, function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
        }
    });


    $(document).on('keyup', inputName, function () {
        let value = $(this).val().toLowerCase();
        let visibleRows = 0;

        $(tableName + ' tbody tr').each(function () {
            const isVisible = $(this).text().toLowerCase().indexOf(value) > -1;
            $(this).toggle(isVisible);

            if (isVisible) visibleRows++;
        });

        if (value === "") {
            if (typeof paginateTable === "function") {
                paginateTable(tableName, 5);  
                paginateTable(tableName, 5,paginate); 
            }
        } else {
            $(paginate).html('');
        }
    });
}
