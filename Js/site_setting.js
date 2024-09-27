document.addEventListener('DOMContentLoaded', function () {
    const menuItems = document.querySelectorAll('.sub-menu-parent');


    menuItems.forEach(menuItem => {
        menuItem.addEventListener('click', function () {
            toggleDropdown(this);
            
        });

        menuItem.addEventListener('mouseover', function (event) {
            event.stopPropagation();
        });

        menuItem.addEventListener('mouseout', function (event) {
            event.stopPropagation();
        });

    });

});

function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const logo = document.querySelector('.logo');
    
    // Toggle the sidebar open/closed state
    if (sidebar.classList.contains('closed')) {
        openSidebar();
    } else {
        closeSidebar();
    }
}

function openSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const headerSidebar = document.querySelector('.app-navbar');
    sidebar.classList.remove('closed');
    sidebar.classList.add('opened');
    
    sidebar.style.width = "240px"; // Set width to open state

    const logo = document.querySelector('.logo');
    if (logo) {
        logo.style.display = "block"; // Show logo
    }

    // Show text elements after a delay for a smooth transition
    setTimeout(() => {
        const textElements = document.querySelectorAll('.nav-text');
        textElements.forEach(textElem => {
            textElem.style.display = "inline-block"; // Show text elements
        });
    }, 200);
}

function closeSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.add('closed');
    sidebar.classList.remove('opened');

    sidebar.style.width = "60px"; // Set width to closed state

    const logo = document.querySelector('.logo');
    if (logo) {
        logo.style.display = "none"; // Hide logo
    }

    const textElements = document.querySelectorAll('.nav-text');
    textElements.forEach(textElem => {
        textElem.style.display = "none"; // Hide text elements
    });

    closeAllDropdowns(); // Close all dropdowns if sidebar closes
}

function toggleDropdown(element) {
    const subMenu = element.querySelector('.sub-menu');
    const icon = element.querySelector('.bi-chevron-down, .bi-chevron-up');

    if (subMenu) {
        const isOpen = subMenu.classList.contains('open');
        closeAllDropdowns(); // Close other dropdowns

        if (!isOpen) {
            subMenu.classList.add('open');
            subMenu.style.height = `${subMenu.scrollHeight}px`;
        } else {
            subMenu.classList.remove('open');
            subMenu.style.height = '0px';
        }
    }

    if (icon) {
        icon.classList.toggle('bi-chevron-up');
        icon.classList.toggle('bi-chevron-down');
    }
}

function closeAllDropdowns() {
    const openDropdowns = document.querySelectorAll('.sub-menu.open');
    openDropdowns.forEach(dropdown => {
        dropdown.classList.remove('open');
        dropdown.style.height = '0px';

        const icon = dropdown.parentElement.querySelector('.bi-chevron-down, .bi-chevron-up');
        if (icon) {
            icon.classList.remove('bi-chevron-up');
            icon.classList.add('bi-chevron-down');
        }
    });
}
