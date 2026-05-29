<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="keyword" content="" />
    <meta name="author" content="flexilecode" />
    <title>Duralux || Dashboard</title>
    
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('template/assets/images/favicon.ico') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('template/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('template/assets/vendors/css/vendors.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('template/assets/vendors/css/daterangepicker.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('template/assets/css/theme.min.css') }}" />
    
    <style>
    .nxl-container {
        flex: 1 0 auto;
        display: flex;
        flex-direction: column;
    }

    .nxl-content {
        flex: 1 0 auto;
    }

    .footer {
        flex-shrink: 0;
    }

    /* Hapus efek blur saat modal terbuka */
    .modal-backdrop {
        backdrop-filter: none !important;
        -webkit-backdrop-filter: none !important;
    }
    .nxl-navigation,
    .nxl-header,
    .nxl-container {
        filter: none !important;
        backdrop-filter: none !important;
        -webkit-backdrop-filter: none !important;
    }
    body.modal-open .nxl-navigation,
    body.modal-open .nxl-header,
    body.modal-open .nxl-container {
        filter: none !important;
    }
    </style>

</head>

<body class="d-flex flex-column min-vh-100">
    
    @include('layouts.partials.sidebar')

    @include('layouts.partials.header')

    @include('layouts.partials.themecustom')

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-content">
                
                @yield('content')
                
            </div>
        </div>
        
        @include('layouts.partials.footer')
        
    </main>

    <script src="{{ asset('template/assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('template/assets/vendors/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('template/assets/vendors/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('template/assets/vendors/js/circle-progress.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/common-init.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/dashboard-init.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/theme-customizer-init.min.js') }}"></script>

    <script>
        // SEARCH HIGHLIGHT FUNCTIONALITY - INLINE SCRIPT
        // Add CSS animation for highlight effect - INJECT IMMEDIATELY
        const style = document.createElement('style');
        style.textContent = `
            /* Highlight Row Styles - Professional Shadow Effect with Blue Theme */
            .highlight-row {
                background-color: rgba(59, 130, 246, 0.08) !important;
                box-shadow: 
                    0 0 0 2px rgba(59, 130, 246, 0.3),
                    0 4px 20px rgba(59, 130, 246, 0.2),
                    inset 0 0 0 1px rgba(59, 130, 246, 0.1) !important;
                position: relative !important;
                transition: all 0.3s ease !important;
                animation: highlightPulse 2.5s ease-in-out infinite !important;
            }
            
            .highlight-row.highlight-fade {
                animation: fadeHighlight 2s ease-out forwards !important;
            }
            
            @keyframes highlightPulse {
                0%, 100% {
                    background-color: rgba(59, 130, 246, 0.08);
                    box-shadow: 
                        0 0 0 2px rgba(59, 130, 246, 0.3),
                        0 4px 20px rgba(59, 130, 246, 0.2),
                        inset 0 0 0 1px rgba(59, 130, 246, 0.1);
                }
                50% {
                    background-color: rgba(59, 130, 246, 0.12);
                    box-shadow: 
                        0 0 0 2px rgba(59, 130, 246, 0.5),
                        0 8px 30px rgba(59, 130, 246, 0.35),
                        inset 0 0 0 1px rgba(59, 130, 246, 0.2);
                }
            }
            
            @keyframes fadeHighlight {
                0% {
                    background-color: rgba(59, 130, 246, 0.12);
                    box-shadow: 
                        0 0 0 2px rgba(59, 130, 246, 0.5),
                        0 8px 30px rgba(59, 130, 246, 0.35),
                        inset 0 0 0 1px rgba(59, 130, 246, 0.2);
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
        });
    </script>

    <script>
        // Global Search Functionality
        const searchInput = document.getElementById('global-search-input');
        const searchResultsContainer = document.getElementById('search-results-container');
        const searchClearBtn = document.getElementById('search-clear-btn');
        let searchTimeout;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length < 1) {
                // Reset ke default
                searchResultsContainer.innerHTML = `
                    <div class="px-4 py-3 text-center text-muted">
                        <p class="fs-12 mb-0">Ketik untuk mencari member, coach, produk, dan lainnya...</p>
                    </div>
                `;
                return;
            }

            // Show loading state
            searchResultsContainer.innerHTML = `
                <div class="px-4 py-3 text-center">
                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                        <span class="visually-hidden">Mencari...</span>
                    </div>
                </div>
            `;

            // Debounce search request
            searchTimeout = setTimeout(() => {
                fetch(`{{ route('admin.search') }}?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error || !data.results || Object.keys(data.results).length === 0) {
                            searchResultsContainer.innerHTML = `
                                <div class="px-4 py-3 text-center text-muted">
                                    <p class="fs-12 mb-0">Tidak ada hasil yang ditemukan untuk "${query}"</p>
                                </div>
                            `;
                            return;
                        }

                        // Render results
                        let html = '';
                        let isFirst = true;

                        for (const [key, category] of Object.entries(data.results)) {
                            if (!isFirst) {
                                html += '<div class="dropdown-divider my-2"></div>';
                            }
                            
                            html += `
                                <div class="px-4 py-2">
                                    <h5 class="fs-13 fw-semibold text-dark mb-3">
                                        <i class="feather ${category.icon} me-2"></i>${category.title}
                                    </h5>
                            `;

                            category.items.forEach(item => {
                                html += `
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-text rounded" style="font-size: 0.75rem;">
                                                <i class="feather ${category.icon}"></i>
                                            </div>
                                            <div>
                                                <a href="${item.url}" class="font-body fw-semibold d-block mb-0" style="font-size: 0.875rem; color: inherit;">
                                                    ${item.name}
                                                </a>
                                                <p class="fs-12 text-muted mb-0">${item.subtitle}</p>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });

                            html += '</div>';
                            isFirst = false;
                        }

                        searchResultsContainer.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        searchResultsContainer.innerHTML = `
                            <div class="px-4 py-3 text-center text-danger">
                                <p class="fs-12 mb-0">Terjadi kesalahan saat mencari</p>
                            </div>
                        `;
                    });
            }, 300); // Debounce delay
        });

        // Clear button functionality
        searchClearBtn.addEventListener('click', function() {
            searchInput.value = '';
            searchInput.focus();
            searchResultsContainer.innerHTML = `
                <div class="px-4 py-3 text-center text-muted">
                    <p class="fs-12 mb-0">Ketik untuk mencari member, coach, produk, dan lainnya...</p>
                </div>
            `;
        });
    </script>
</body>

</html>