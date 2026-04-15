let path_page = window.location.href.split("/")[4];


/* Start Status */
    function updateStatus(status) {
        fetch('./status/update_status.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({status , page : `${path_page}`})
        });
    }
    
    updateStatus('online');
    
    window.addEventListener('beforeunload', () => {
        updateStatus('offline');
    });
    
    setInterval(() => {
        updateStatus('online');
    }, 30000); 
/* End Status */  