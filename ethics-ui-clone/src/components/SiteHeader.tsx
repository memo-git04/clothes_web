import React, { useState } from 'react';
import { NavLink } from 'react-router-dom';
import MobileMenu from './MobileMenu';

const navItems = [
  { to: '/', label: 'Home' },
  { to: '/about', label: 'About' },
  { to: '/blog', label: 'Blog' },
  { to: '/faq', label: 'FAQ' },
  { to: '/contact', label: 'Contact' },
];

export default function SiteHeader() {
  const [open, setOpen] = useState(false);

  return (
    <header className="w-full sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-black/5">
      {open && <MobileMenu open={open} onClose={() => setOpen(false)} />}

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
        <div className="flex items-center gap-3">
          <img
            src="https://demo-egenslab.b-cdn.net/html/ethics-html/preview/assets/image/ethics-logo-dark.svg"
            alt="Ethics"
            className="h-8 w-auto"
          />
        </div>

        <nav className="hidden md:flex items-center gap-6 text-sm">
          {navItems.map((item) => (
            <NavLink
              key={item.to}
              to={item.to}
              className={({ isActive }) =>
                [
                  'relative transition-colors',
                  isActive ? 'text-black' : 'text-black/70 hover:text-black',
                ].join(' ')
              }
            >
              {item.label}
            </NavLink>
          ))}
        </nav>

        <div className="flex items-center gap-2 text-sm text-black/70">
          <button className="hidden md:inline-flex items-center gap-2 rounded-full border border-black/10 px-4 py-2 hover:border-black/20 hover:text-black transition-colors">
            Search
          </button>
          <button
            className="md:hidden rounded-full border border-black/10 px-3 py-2 hover:border-black/20 transition-colors"
            type="button"
            onClick={() => setOpen(true)}
            aria-label="Open menu"
          >
            Menu
          </button>
        </div>
      </div>
    </header>
  );
}

