import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();



const webspaceId = document.getElementById('webspace-id').value;

function checkDeployStatus() {
    fetch(`/webspace/${webspaceId}/status`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('deploy-status').innerText =
                data.status;
        })

        .catch(error => {
            console.error(error);
        });
}

setInterval(checkDeployStatus, 5000);
