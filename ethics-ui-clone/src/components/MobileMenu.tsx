import React from 'react';
import { NavLink } from 'react-router-dom';

type NavItem = { to: string; label: string };

const navItems: NavItem[] = [
  { to: '/', label: 'Home' },
  { to: '/about', label: 'About' },
  { to: '/blog', label: 'Blog' },
  { to: '/faq', label: 'FAQ' },
  { to: '/contact', label: 'Contact' },
];

export default function MobileMenu({
  open,
  onClose,
}: {
  open: boolean;
  onClose: () => void;
}) {
  return (
    <>
      {/* Backdrop */}
      <div
        className={[
          'fixed inset-0 z-[60] bg-black/40 transition-opacity',
          open ? 'opacity-100' : 'pointer-events-none opacity-0',
        ].join(' ')}
        onClick={onClose}
        aria-hidden="true"
      />

      {/* Side panel */}
      <aside
        className={[
          'fixed right-0 top-0 z-[70] h-full w-[84%] max-w-[360px] bg-white shadow-2xl transition-transform',
          open ? 'translate-x-0' : 'translate-x-full',
        ].join(' ')}
        aria-label="Mobile menu"
      >
        <div className="flex items-center justify-between px-4 py-4 border-b border-black/5">
          <img
            src="https://demo-egenslab.b-cdn.net/html/ethics-html/preview/assets/image/ethics-logo-dark.svg"
            alt="Ethics"
            className="h-7 w-auto"
          />
          <button
            type="button"
            onClick={onClose}
            className="rounded-full border border-black/10 px-3 py-2 text-sm hover:border-black/20 hover:text-black transition-colors"
            aria-label="Close menu"
          >
            Close
          </button>
        </div>

        <nav className="p-4 flex flex-col gap-2">
          {navItems.map((item) => (
            <NavLink
              key={item.to}
              to={item.to}
              end={item.to === '/'}
              onClick={onClose}
              className={({ isActive }) =>
                [
                  'rounded-lg px-3 py-2 text-sm transition-colors border',
                  isActive
                    ? 'border-black/20 bg-black/5 text-black'
                    : 'border-transparent text-black/70 hover:border-black/10 hover:bg-black/5 hover:text-black',
                ].join(' ')
              }
            >
              {item.label}
            </NavLink>
          ))}
        </nav>

        <div className="px-4 pb-6 text-xs text-black/50">
          Free shipping world wide for all orders over $499.
        </div>
      </aside>
    </>
  );
}

