import React from 'react';

export type TestimonialModel = {
  quote: string;
  name: string;
  role?: string;
};

export default function TestimonialCard({ item }: { item: TestimonialModel }) {
  return (
    <div className="rounded-2xl border border-black/5 bg-white p-7">
      <div className="text-black/80 leading-relaxed text-sm">{item.quote}</div>
      <div className="mt-5">
        <div className="font-semibold text-black">{item.name}</div>
        {item.role ? <div className="text-sm text-black/60">{item.role}</div> : null}
      </div>
    </div>
  );
}

