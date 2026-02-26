// Add CSS animation for highlight effect - INJECT IMMEDIATELY
const style = document.createElement('style');
style.textContent = `
    /* Highlight Row Styles - Professional Shadow Effect */
    .highlight-row {
        background-color: rgba(255, 193, 7, 0.08) !important;
        box-shadow: 
            0 0 0 2px rgba(255, 193, 7, 0.3),
            0 4px 20px rgba(255, 193, 7, 0.2),
            inset 0 0 0 1px rgba(255, 193, 7, 0.1) !important;
        position: relative !important;
        transition: all 0.3s ease !important;
        animation: highlightPulse 2.5s ease-in-out infinite !important;
    }
    
    .highlight-row.highlight-fade {
        animation: fadeHighlight 2s ease-out forwards !important;
    }
    
    @keyframes highlightPulse {
        0%, 100% {
            background-color: rgba(255, 193, 7, 0.08);
            box-shadow: 
                0 0 0 2px rgba(255, 193, 7, 0.3),
                0 4px 20px rgba(255, 193, 7, 0.2),
                inset 0 0 0 1px rgba(255, 193, 7, 0.1);
        }
        50% {
            background-color: rgba(255, 193, 7, 0.12);
            box-shadow: 
                0 0 0 2px rgba(255, 193, 7, 0.5),
                0 8px 30px rgba(255, 193, 7, 0.35),
                inset 0 0 0 1px rgba(255, 193, 7, 0.2);
        }
    }
    
    @keyframes fadeHighlight {
        0% {
            background-color: rgba(255, 193, 7, 0.12);
            box-shadow: 
                0 0 0 2px rgba(255, 193, 7, 0.5),
                0 8px 30px rgba(255, 193, 7, 0.35),
                inset 0 0 0 1px rgba(255, 193, 7, 0.2);
            opacity: 1;
        }
        100% {
            background-color: transparent;
            box-shadow: none;
            opacity: 1;
        }
    }
`;
document.head.appendChild(style);

// Search Highlight Functionality
document.addEventListener('DOMContentLoaded', function() {
    console.log('Search highlight script loaded');
    
    // Get the highlighted ID from URL hash
    const hash = window.location.hash;
    console.log('Hash:', hash);
    
    if (hash) {
        // Extract the ID from hash (e.g., #member-1 -> member-1)
        const highlightId = hash.substring(1);
        console.log('Looking for element with ID:', highlightId);
        
        const highlightElement = document.getElementById(highlightId);
        console.log('Element found:', highlightElement);
        
        if (highlightElement) {
            // Small delay untuk memastikan DOM sudah siap
            setTimeout(() => {
                console.log('Starting highlight animation for:', highlightId);
                
                // Get element position
                const elementTop = highlightElement.offsetTop;
                const elementHeight = highlightElement.offsetHeight;
                const windowHeight = window.innerHeight;
                const headerHeight = 80; // Approximate header height
                
                // Calculate scroll position to center element (accounting for header)
                const scrollPosition = elementTop - headerHeight - (windowHeight / 2) + (elementHeight / 2);
                
                console.log('Scrolling to position:', scrollPosition);
                
                // Smooth scroll to center
                window.scrollTo({
                    top: Math.max(0, scrollPosition),
                    behavior: 'smooth'
                });
                
                // Add highlight class after a short delay
                setTimeout(() => {
                    console.log('Adding highlight class');
                    highlightElement.classList.add('highlight-row');
                }, 400);
                
                // Keep highlight for 5 seconds then fade out
                setTimeout(() => {
                    console.log('Adding fade class');
                    highlightElement.classList.add('highlight-fade');
                }, 5400);
                
                // Remove highlight class after animation
                setTimeout(() => {
                    console.log('Removing highlight classes');
                    highlightElement.classList.remove('highlight-row', 'highlight-fade');
                }, 7400);
            }, 100);
        } else {
            console.warn('Element with ID not found:', highlightId);
        }
    } else {
        console.log('No hash in URL');
    }
    
    // Also check for search query param and filter table if needed
    const urlParams = new URLSearchParams(window.location.search);
    const searchParam = urlParams.get('search');
    
    if (searchParam) {
        console.log('Search param:', searchParam);
    }
});
