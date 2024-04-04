// Color Mode Toggler
(() => {
    'use strict'

    const storedTheme = localStorage.getItem('theme')

    const getPreferredTheme = () => {
        if (storedTheme) {
            return storedTheme
        }

        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
    }

    const setTheme = function (theme) {
        if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.setAttribute('data-bs-theme', 'dark')
        } else {
            document.documentElement.setAttribute('data-bs-theme', theme)
        }
    }

    setTheme(getPreferredTheme())

    const showActiveTheme = theme => {
        const activeThemeIcon = document.querySelector('.theme-icon-active')
        const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)

        document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
            element.classList.remove('active')
        })

        btnToActive.classList.add('active')
        activeThemeIcon.innerHTML = theme === "light" ? '<i class="fa-solid fa-sun me-2 opacity-50"></i>' : '<i class="fa-solid fa-moon me-2 opacity-50"></i>';
    }

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        if (storedTheme !== 'light' || storedTheme !== 'dark') {
            setTheme(getPreferredTheme())
        }
    })

    window.addEventListener('DOMContentLoaded', () => {
        showActiveTheme(getPreferredTheme());

        document.querySelectorAll('[data-bs-theme-value]')
            .forEach(toggle => {
                toggle.addEventListener('click', () => {
                    const theme = toggle.getAttribute('data-bs-theme-value')
                    localStorage.setItem('theme', theme)
                    setTheme(theme)
                    showActiveTheme(theme)
                })
            })
    })
})()

const pushmenu = document.getElementsByClassName('pushmenu')[0];
pushmenu.addEventListener('click', function () {
    if (document.getElementsByTagName('body')[0].classList.contains('sidebar-collapse')) {
        pushmenu.innerHTML = '<i class="fa-solid fa-angles-left"></i>';
    } else {
        pushmenu.innerHTML = '<i class="fa-solid fa-angles-right"></i>';
    }
})

// Refresh fixer
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

// Bootstrap tooltip
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

// Select2 init
$(document).ready(function () {
    $('.select2').select2({
        theme: 'bootstrap-5',
    });
});