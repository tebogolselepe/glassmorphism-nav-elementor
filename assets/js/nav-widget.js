class GlassmorphismNavWidget {
    constructor(root) {
        this.root = root;
        this.navbar = root.querySelector('.navbar');
        this.toggleMenuBtn = root.querySelector('.toggle-menu-btn');
        this.navMenu = root.querySelector('.nav-menu');
        this.navOverlay = root.querySelector('.nav-overlay');
        this.navLinks = root.querySelectorAll('.nav-link');
        this.currentPageIndicator = root.querySelector('.current-page-text');
        this.isMenuOpen = false;

        if (!this.navbar || !this.toggleMenuBtn || !this.navMenu) {
            return;
        }

        this.init();
    }

    init() {
        this.setupToggleMenu();
        this.setupNavigationLinks();
        this.setupScrollToClose();
    }

    setupToggleMenu() {
        this.toggleMenuBtn.addEventListener('click', () => {
            this.toggleMenu();
        });

        document.addEventListener('click', (event) => {
            if (this.isMenuOpen && !this.root.contains(event.target)) {
                this.closeMenu();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && this.isMenuOpen) {
                this.closeMenu();
            }
        });
    }

    toggleMenu() {
        if (this.isMenuOpen) {
            this.closeMenu();
        } else {
            this.openMenu();
        }
    }

    openMenu() {
        this.isMenuOpen = true;
        this.navbar.setAttribute('data-state', 'open');
        this.toggleMenuBtn.classList.add('active');
        this.navMenu.classList.add('active');
        this.navOverlay.classList.add('active');

        if (typeof gsap !== 'undefined' && this.currentPageIndicator) {
            gsap.to(this.currentPageIndicator, {
                opacity: 0,
                scale: 0.8,
                duration: 0.25,
                ease: 'power2.out'
            });

            const menuItems = this.navMenu.querySelectorAll('.nav-item');
            gsap.fromTo(menuItems, {
                opacity: 0,
                y: 20
            }, {
                opacity: 1,
                y: 0,
                duration: 0.35,
                stagger: 0.08,
                ease: 'power2.out'
            });
        }
    }

    closeMenu() {
        this.isMenuOpen = false;
        this.navbar.setAttribute('data-state', 'closed');
        this.toggleMenuBtn.classList.remove('active');
        this.navMenu.classList.remove('active');
        this.navOverlay.classList.remove('active');

        if (typeof gsap !== 'undefined' && this.currentPageIndicator) {
            gsap.to(this.currentPageIndicator, {
                opacity: 1,
                scale: 1,
                duration: 0.25,
                ease: 'power2.out'
            });
        }
    }

    setupNavigationLinks() {
        if (this.navLinks.length === 0) {
            return;
        }

        this.navLinks.forEach(link => {
            link.addEventListener('click', (event) => {
                const target = link.getAttribute('href') || '#';
                const linkText = link.querySelector('.nav-text')?.textContent || link.textContent;

                if (target.startsWith('#')) {
                    event.preventDefault();
                }

                this.handleNavigation(link, linkText, target);
            });
        });
    }

    handleNavigation(link, linkText, target) {
        if (linkText && linkText.trim() !== '') {
            this.updateCurrentPage(linkText.trim());
        }

        if (this.isMenuOpen) {
            this.closeMenu();
        }

        if (target.startsWith('#')) {
            const targetElement = document.querySelector(target);
            if (targetElement) {
                this.smoothScrollTo(targetElement);
            }
        }
    }

    updateCurrentPage(pageText) {
        if (!this.currentPageIndicator) {
            return;
        }

        this.currentPageIndicator.textContent = pageText;
        this.navLinks.forEach(navLink => navLink.classList.remove('active'));
        const currentLink = Array.from(this.navLinks).find(navLink => navLink.querySelector('.nav-text')?.textContent === pageText);
        if (currentLink) {
            currentLink.classList.add('active');
        }
    }

    setupScrollToClose() {
        let lastScrollY = window.scrollY;

        window.addEventListener('scroll', () => {
            const currentScrollY = window.scrollY;
            if (this.isMenuOpen && Math.abs(currentScrollY - lastScrollY) > 10) {
                this.closeMenu();
            }
            lastScrollY = currentScrollY;
        });
    }

    smoothScrollTo(element) {
        window.scrollTo({
            top: element.offsetTop,
            behavior: 'smooth'
        });
    }
}

function initGlassmorphismNavWidgets() {
    document.querySelectorAll('.glassmorphism-nav-widget').forEach((widgetRoot) => {
        new GlassmorphismNavWidget(widgetRoot);
    });
}

document.addEventListener('DOMContentLoaded', initGlassmorphismNavWidgets);
