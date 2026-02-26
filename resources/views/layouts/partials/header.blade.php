<header class="nxl-header">
    <div class="header-wrapper">
        <!--! [Start] Header Left !-->
        <div class="header-left d-flex align-items-center gap-4">
            <!--! [Start] nxl-head-mobile-toggler !-->
            <a
                href="javascript:void(0);"
                class="nxl-head-mobile-toggler"
                id="mobile-collapse">
                <div class="hamburger hamburger--arrowturn">
                    <div class="hamburger-box">
                        <div class="hamburger-inner"></div>
                    </div>
                </div>
            </a>
            <!--! [Start] nxl-head-mobile-toggler !-->
            <!--! [Start] nxl-navigation-toggle !-->
            <div class="nxl-navigation-toggle">
                <a href="javascript:void(0);" id="menu-mini-button">
                    <i class="feather-align-left"></i>
                </a>
                <a href="javascript:void(0);" id="menu-expend-button" style="display: none">
                    <i class="feather-arrow-right"></i>
                </a>
            </div>
            <!--! [End] nxl-navigation-toggle !-->
            <!--! [Start] nxl-lavel-mega-menu-toggle !-->
            <div class="nxl-lavel-mega-menu-toggle d-flex d-lg-none">
                <a href="javascript:void(0);" id="nxl-lavel-mega-menu-open">
                    <i class="feather-align-left"></i>
                </a>
            </div>
            <!--! [End] nxl-lavel-mega-menu-toggle !-->
        </div>
        <!--! [End] Header Left !-->
        <!--! [Start] Header Right !-->
        <div class="header-right ms-auto">
            <div class="d-flex align-items-center">
                <div class="dropdown nxl-h-item nxl-header-search">
                    <a
                        href="javascript:void(0);"
                        class="nxl-head-link me-0"
                        data-bs-toggle="dropdown"
                        data-bs-auto-close="outside">
                        <i class="feather-search"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-search-dropdown" style="min-width: 500px;">
                        <div class="input-group search-form">
                            <span class="input-group-text">
                                <i class="feather-search fs-6 text-muted"></i>
                            </span>
                            <input
                                type="text"
                                class="form-control search-input-field"
                                id="global-search-input"
                                placeholder="Cari member, coach, produk..."/>
                            <span class="input-group-text">
                                <button type="button" class="btn-close" id="search-clear-btn"></button>
                            </span>
                        </div>
                        <div class="dropdown-divider mt-0"></div>
                        <div class="search-items-wrapper" id="search-results-container">
                            <div class="px-4 py-3 text-center text-muted">
                                <p class="fs-12 mb-0">Ketik untuk mencari member, coach, produk, dan lainnya...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="nxl-h-item d-none d-sm-flex">
                    <div class="full-screen-switcher">
                        <a
                            href="javascript:void(0);"
                            class="nxl-head-link me-0"
                            onclick="$('body').fullScreenHelper('toggle');">
                            <i class="feather-maximize maximize"></i>
                            <i class="feather-minimize minimize"></i>
                        </a>
                    </div>
                </div>
                <div class="nxl-h-item dark-light-theme">
                    <a href="javascript:void(0);" class="nxl-head-link me-0 dark-button">
                        <i class="feather-moon"></i>
                    </a>
                    <a
                        href="javascript:void(0);"
                        class="nxl-head-link me-0 light-button"
                        style="display: none">
                        <i class="feather-sun"></i>
                    </a>
                </div>
                <div class="dropdown nxl-h-item">
                    <a
                        class="nxl-head-link me-3"
                        data-bs-toggle="dropdown"
                        href="#"
                        role="button"
                        data-bs-auto-close="outside">
                        <i class="feather-bell"></i>
                        <span class="badge bg-danger nxl-h-badge">3</span>
                    </a>
                    <div
                        class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-notifications-menu">
                        <div
                            class="d-flex justify-content-between align-items-center notifications-head">
                            <h6 class="fw-bold text-dark mb-0">Notifications</h6>
                            <a
                                href="javascript:void(0);"
                                class="fs-11 text-success text-end ms-auto"
                                data-bs-toggle="tooltip"
                                title="Make as Read">
                                <i class="feather-check"></i>
                                <span>Make as Read</span>
                            </a>
                        </div>
                        <div class="notifications-item">
                            <img
                                src="{{ asset('template/assets/images/avatar/2.png') }}"
                                alt=""
                                class="rounded me-3 border"/>
                            <div class="notifications-desc">
                                <a href="javascript:void(0);" class="font-body text-truncate-2-line">
                                    <span class="fw-semibold text-dark">Malanie Hanvey</span>
                                    We should talk about that at lunch!</a>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="notifications-date text-muted border-bottom border-bottom-dashed">2 minutes ago</div>
                                    <div class="d-flex align-items-center float-end gap-2">
                                        <a
                                            href="javascript:void(0);"
                                            class="d-block wd-8 ht-8 rounded-circle bg-gray-300"
                                            data-bs-toggle="tooltip"
                                            title="Make as Read"></a>
                                        <a
                                            href="javascript:void(0);"
                                            class="text-danger"
                                            data-bs-toggle="tooltip"
                                            title="Remove">
                                            <i class="feather-x fs-12"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="notifications-item">
                            <img
                                src="{{ asset('template/assets/images/avatar/3.png') }}"
                                alt=""
                                class="rounded me-3 border"/>
                            <div class="notifications-desc">
                                <a href="javascript:void(0);" class="font-body text-truncate-2-line">
                                    <span class="fw-semibold text-dark">Valentine Maton</span>
                                    You can download the latest invoices now.</a>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="notifications-date text-muted border-bottom border-bottom-dashed">36 minutes ago</div>
                                    <div class="d-flex align-items-center float-end gap-2">
                                        <a
                                            href="javascript:void(0);"
                                            class="d-block wd-8 ht-8 rounded-circle bg-gray-300"
                                            data-bs-toggle="tooltip"
                                            title="Make as Read"></a>
                                        <a
                                            href="javascript:void(0);"
                                            class="text-danger"
                                            data-bs-toggle="tooltip"
                                            title="Remove">
                                            <i class="feather-x fs-12"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="notifications-item">
                            <img
                                src="{{ asset('template/assets/images/avatar/4.png') }}"
                                alt=""
                                class="rounded me-3 border"/>
                            <div class="notifications-desc">
                                <a href="javascript:void(0);" class="font-body text-truncate-2-line">
                                    <span class="fw-semibold text-dark">Archie Cantones</span>
                                    Don't forget to pickup Jeremy after school!</a>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="notifications-date text-muted border-bottom border-bottom-dashed">53 minutes ago</div>
                                    <div class="d-flex align-items-center float-end gap-2">
                                        <a
                                            href="javascript:void(0);"
                                            class="d-block wd-8 ht-8 rounded-circle bg-gray-300"
                                            data-bs-toggle="tooltip"
                                            title="Make as Read"></a>
                                        <a
                                            href="javascript:void(0);"
                                            class="text-danger"
                                            data-bs-toggle="tooltip"
                                            title="Remove">
                                            <i class="feather-x fs-12"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center notifications-footer">
                            <a href="javascript:void(0);" class="fs-13 fw-semibold text-dark">Alls Notifications</a>
                        </div>
                    </div>
                </div>
                <div class="dropdown nxl-h-item">
                    <a
                        href="javascript:void(0);"
                        data-bs-toggle="dropdown"
                        role="button"
                        data-bs-auto-close="outside">
                        <i class="feather-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-user-dropdown">
                        <div class="dropdown-header">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="text-dark mb-0">{{ Auth::user()->name ?? 'Admin' }}</h6>
                                    <span class="fs-12 fw-medium text-muted">{{ Auth::user()->email ?? '' }}</span>
                                </div>
                            </div>
                        </div>
                        <form
                            id="logout-form"
                            action="{{ route('logout') }}"
                            method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                        <a
                            href="javascript:void(0);"
                            class="dropdown-item"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="feather-log-out"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!--! [End] Header Right !-->
    </div>
</header>

<!-- IMPROVED SEARCH STYLES -->
<style>
    /* Search dropdown sizing */
    .nxl-search-dropdown {
        min-width: 500px !important;
    }
    
    .nxl-search-dropdown .search-items-wrapper {
        max-height: 380px;
        overflow-y: auto;
        padding: 0;
    }
    
    /* Category styling */
    .nxl-search-dropdown .search-category {
        padding: 8px 4px;
        margin-top: 8px;
        margin-bottom: 4px;
    }
    
    .nxl-search-dropdown .search-category:first-of-type {
        margin-top: 0;
    }
    
    .nxl-search-dropdown .search-category-title {
        font-size: 0.7rem;
        font-weight: 700;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
        padding: 0 12px;
    }
    
    /* Result item styling */
    .nxl-search-dropdown .search-result-item {
        padding: 8px 12px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        text-decoration: none;
        color: inherit;
        margin: 0 4px 2px 4px;
    }
    
    .nxl-search-dropdown .search-result-item:hover {
        background-color: #f3f4f6;
        transform: translateX(2px);
    }
    
    .nxl-search-dropdown .search-result-icon {
        width: 28px;
        height: 28px;
        min-width: 28px;
        border-radius: 4px;
        background-color: #eff6ff;
        color: #3b82f6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        margin-top: 2px;
    }
    
    .nxl-search-dropdown .search-result-content {
        flex: 1;
        min-width: 0;
    }
    
    .nxl-search-dropdown .search-result-title {
        font-size: 0.85rem;
        font-weight: 500;
        color: #1f2937;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .nxl-search-dropdown .search-result-subtitle {
        font-size: 0.75rem;
        color: #9ca3af;
        margin: 2px 0 0 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    /* Input styling improvement */
    .nxl-search-dropdown .search-form {
        padding: 12px;
        margin-bottom: 0;
    }
    
    .nxl-search-dropdown .search-form .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.1);
    }
</style>

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
                            <div class="px-4 py-4 text-center text-muted">
                                <i class="feather-inbox d-block mb-2" style="font-size: 1.2rem; opacity: 0.5;"></i>
                                <p class="fs-12 mb-0">Tidak ada hasil untuk "${query}"</p>
                            </div>
                        `;
                        return;
                    }

                    // Render results
                    let html = '';
                    let isFirst = true;

                    for (const [key, category] of Object.entries(data.results)) {
                        if (!isFirst) {
                            // No divider, just space
                        }
                        
                        html += `
                            <div class="search-category">
                                <div class="search-category-title">
                                    <i class="feather ${category.icon}" style="font-size: 11px; margin-right: 6px;"></i>${category.title}
                                </div>
                        `;

                        category.items.forEach(item => {
                            html += `
                                <a href="${item.url}" class="search-result-item">
                                    <div class="search-result-icon">
                                        <i class="feather ${category.icon}"></i>
                                    </div>
                                    <div class="search-result-content">
                                        <p class="search-result-title">${item.name}</p>
                                        <p class="search-result-subtitle">${item.subtitle}</p>
                                    </div>
                                </a>
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
                        <div class="px-4 py-4 text-center text-muted">
                            <i class="feather-alert-circle d-block mb-2" style="font-size: 1.2rem; opacity: 0.5;"></i>
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

    // Prevent dropdown from closing when clicking inside
    document.querySelectorAll('.nxl-search-dropdown').forEach(dropdown => {
        dropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });

    // Prevent timesheets and notifications dropdown from closing on internal clicks
    document.querySelectorAll('.nxl-timesheets-menu, .nxl-notifications-menu').forEach(dropdown => {
        dropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });

    // Close dropdown only when clicking outside
    document.addEventListener('click', function(e) {
        const searchDropdown = document.querySelector('.dropdown.nxl-h-item.nxl-header-search');
        const timesheetsDropdown = document.querySelector('.dropdown.nxl-h-item:has(.nxl-timesheets-menu)');
        const notificationsDropdown = document.querySelector('.dropdown.nxl-h-item:has(.nxl-notifications-menu)');

        // Close search dropdown jika click di luar
        if (searchDropdown && !searchDropdown.contains(e.target)) {
            const searchToggle = searchDropdown.querySelector('[data-bs-toggle="dropdown"]');
            if (searchToggle && searchToggle.classList.contains('show')) {
                // Keep it open hanya untuk dropdowns dengan auto-close=outside
            }
        }
    });
</script>
</header>