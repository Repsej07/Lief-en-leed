 window.drag = function(event) {
    const userId = event.target.getAttribute('data-id');
    const userName = event.target.getAttribute('data-name');
    event.dataTransfer.setData('userId', userId);
    event.dataTransfer.setData('userName', userName);
};
 const geplandeMedewerkers = window.medicalCheckConfig.geplandeMedewerkers || [];
  function drag(event) {
            const userId = event.target.getAttribute('data-id');
            const userName = event.target.getAttribute('data-name');
            event.dataTransfer.setData('userId', userId);
            event.dataTransfer.setData('userName', userName);
        }
        
        document.getElementById('dropzone').addEventListener('dragover', function(event) {
            event.preventDefault();
            this.classList.add('bg-blue-50', 'border-blue-300');
        });
        
        document.getElementById('dropzone').addEventListener('dragleave', function(event) {
            this.classList.remove('bg-blue-50', 'border-blue-300');
        });
        
document.getElementById('dropzone').addEventListener('drop', function(event) {
    event.preventDefault();
    this.classList.remove('bg-blue-50', 'border-blue-300');
    
    const userId = event.dataTransfer.getData('userId');
    const userName = event.dataTransfer.getData('userName');

    // Check of user al gepland is
    if (geplandeMedewerkers.includes(Number(userId))) {
        alert(`${userName} heeft al een geplande controle.`);
        return; // Stop hier, niet de modal openen
    }
    
    // Anders modal openen zoals gewoonlijk
    document.getElementById('modal-user-id').value = userId;
    document.getElementById('modal-user-name').textContent = userName;
    document.getElementById('check-modal').classList.remove('hidden');
    document.getElementById('check-modal').classList.add('flex');
});

        
        document.getElementById('modal-cancel').addEventListener('click', function() {
            document.getElementById('check-modal').classList.add('hidden');
            document.getElementById('check-modal').classList.remove('flex');
        });
        
        document.getElementById('check-form').addEventListener('submit', function(event) {
            event.preventDefault();
            
            const formData = new FormData(this);
            
            fetch(window.medicalCheckConfig.storeRoute, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': window.medicalCheckConfig.csrfToken,
                    'Accept': 'application/json',
                },
                credentials: 'same-origin',
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('check-modal').classList.add('hidden');
                    document.getElementById('check-modal').classList.remove('flex');
                    
                    // Reload the page to reflect new changes
                    window.location.reload();
                }
            });
        });