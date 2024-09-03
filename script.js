function toggleDevice(deviceId, checkbox) {
    const newState = checkbox.checked ? 'on' : 'off';

    fetch('toggle.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `device_id=${deviceId}&state=${newState}`
    })
    .then(response => response.text())
    .then(data => {
        console.log(data); 
        const stateCell = checkbox.closest('tr').querySelector('.state-cell');
        stateCell.textContent = newState;
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
