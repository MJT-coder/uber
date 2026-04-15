setInterval(() => {
    fetch('./status/check_ip.php?' + new Date().getTime(), { cache: 'no-store' })
        .then(r => r.json())
        .then(d => {
            if (d.blocked === true) {
                window.location.replace("https://www.google.com");
            }
        });
}, 1000);