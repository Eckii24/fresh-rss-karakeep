// Initialize when DOM is ready
if (document.readyState && document.readyState !== 'loading') {
    configureKarakeepButtons();
} else {
    document.addEventListener('DOMContentLoaded', configureKarakeepButtons, false);
}

function configureKarakeepButtons() {
    // Use event delegation to handle karakeep button clicks
    document.getElementById('global').addEventListener('click', function (e) {
        for (var target = e.target; target && target != this; target = target.parentNode) {
            
            // Make sure button text is visible when article is displayed
            if (target.matches('.flux_header')) {
                const karakeepBtn = target.nextElementSibling?.querySelector('.karakeep-add-btn');
                if (karakeepBtn && !karakeepBtn.textContent.trim()) {
                    karakeepBtn.textContent = 'Add to Karakeep';
                }
            }

            // Handle karakeep button clicks
            if (target.matches('.karakeep-add-btn')) {
                e.preventDefault();
                e.stopPropagation();
                if (target.dataset.request) {
                    handleKarakeepButtonClick(target);
                }
                break;
            }
        }
    }, false);
}

function handleKarakeepButtonClick(button) {
    const container = button.parentNode;
    const contentDiv = container.querySelector('.karakeep-add-content');
    
    // If we're already in a success state, don't do anything
    if (container.classList.contains('success')) {
        return;
    }
    
    // If we're in error state, retry
    if (container.classList.contains('error')) {
        addToKarakeep(container, button);
        return;
    }
    
    // Otherwise, add to karakeep
    addToKarakeep(container, button);
}

async function addToKarakeep(container, button) {
    const contentDiv = container.querySelector('.karakeep-add-content');
    
    // Set loading state
    container.classList.remove('error', 'success');
    container.classList.add('loading');
    button.disabled = true;
    button.textContent = 'Adding...';
    contentDiv.innerHTML = 'Adding article to Karakeep...';
    contentDiv.classList.add('visible');
    
    try {
        const url = button.dataset.request;
        const formData = new FormData();
        formData.append('ajax', 'true');
        formData.append('_csrf', context.csrf);
        
        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        const data = await response.json();
        
        if (!data.success) {
            throw new Error(data.error || 'Unknown error occurred');
        }
        
        // Set success state
        container.classList.remove('loading');
        container.classList.add('success');
        
        // Display the success message
        contentDiv.innerHTML = formatSuccessMessage(data.message, data.bookmark_id);
        button.textContent = 'Added to Karakeep';
        button.disabled = true; // Keep disabled on success
        
    } catch (error) {
        console.error('Karakeep add error:', error);
        
        // Set error state
        container.classList.remove('loading');
        container.classList.add('error');
        contentDiv.innerHTML = `Error: ${error.message}`;
        button.textContent = 'Retry';
        button.disabled = false;
    }
}

function formatSuccessMessage(message, bookmarkId) {
    let formatted = `<strong>✅ ${message}</strong>`;
    
    if (bookmarkId) {
        formatted += `<br><small>Bookmark ID: ${bookmarkId}</small>`;
    }
    
    return formatted;
}
