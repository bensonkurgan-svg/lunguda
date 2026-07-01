// Livewire 3 bundles Alpine, so we don't import Alpine separately here.
// This file adds two progressive enhancements: scroll-reveal and a
// navigation flag used by the page-transition CSS.

const revealObserver = new IntersectionObserver((entries) => {
    for (const entry of entries) {
        if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            revealObserver.unobserve(entry.target);
        }
    }
}, { rootMargin: '0px 0px -8% 0px', threshold: 0.05 });

function bindReveals() {
    document.querySelectorAll('.reveal:not(.is-visible)').forEach((el) => revealObserver.observe(el));
}

document.addEventListener('DOMContentLoaded', bindReveals);
document.addEventListener('livewire:navigated', () => {
    window.scrollTo({ top: 0, behavior: 'instant' in window ? 'instant' : 'auto' });
    bindReveals();
});

// Flag the document while Livewire swaps pages so CSS can animate the new view.
document.addEventListener('livewire:navigate', () => document.documentElement.setAttribute('data-navigating', ''));
document.addEventListener('livewire:navigated', () => document.documentElement.removeAttribute('data-navigating'));

// Global audio player store (Livewire bundles Alpine; register on alpine:init
// so the store exists before any pronounce button evaluates it).
document.addEventListener('alpine:init', () => {
    window.Alpine.store('audio', {
        current: null,
        el: null,
        play(src, id) {
            if (!src) return;
            if (this.el && this.current === id) { this.stop(); return; }
            this.stop();
            this.el = new Audio(src);
            this.current = id;
            this.el.addEventListener('ended', () => this.stop());
            this.el.play().catch(() => this.stop());
        },
        stop() {
            if (this.el) { this.el.pause(); this.el = null; }
            this.current = null;
        },
    });
});
