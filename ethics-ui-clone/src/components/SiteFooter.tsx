import React from 'react';

export default function SiteFooter() {
  return (
    <footer className="border-t border-black/5 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
          <div>
            <div className="font-semibold text-black">Elite Fashion House</div>
            <div className="text-sm text-black/60 mt-1">
              Free shipping world wide for all orders over $499.
            </div>
          </div>
          <div className="text-sm text-black/60">
            © {new Date().getFullYear()} Ethics UI Clone
          </div>
        </div>
      </div>
    </footer>
  );
}

