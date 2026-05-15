import React from 'react';

export default function NewsletterSection({
  title = 'Subscribe Us to Get',
  subtitle = 'For All The Latest Offer & Discounts. Get 30% off on Your First Oder',
}: {
  title?: string;
  subtitle?: string;
}) {
  return (
    <section className="rounded-3xl bg-black text-white py-12 px-6 md:px-12 overflow-hidden relative">
      <div className="absolute inset-0 opacity-10 pointer-events-none bg-[radial-gradient(circle_at_top,white,transparent_55%)]" />
      <div className="relative max-w-3xl">
        <div className="text-xs tracking-widest uppercase text-white/70">{title}</div>
        <h2 className="mt-3 text-3xl md:text-4xl font-semibold tracking-tight">
          {subtitle}
        </h2>
        <div className="mt-8 flex flex-col sm:flex-row gap-3">
          <input
            className="flex-1 rounded-full bg-white/10 border border-white/20 px-5 py-3 text-sm outline-none placeholder:text-white/60"
            placeholder="Enter your email"
          />
          <button className="rounded-full bg-white text-black px-7 py-3 text-sm font-semibold hover:bg-white/90 transition-colors">
            Subscribe
          </button>
        </div>
      </div>
    </section>
  );
}

