import React from 'react';

export type BlogTeaserModel = {
  title: string;
  date?: string;
  category?: string;
  imageUrl?: string;
  href?: string;
};

export default function BlogTeaserCard({
  item,
}: {
  item: BlogTeaserModel;
}) {
  return (
    <article className="group border border-black/5 bg-white rounded-2xl overflow-hidden transition-transform duration-300 hover:-translate-y-1">
      {item.imageUrl ? (
        <div className="h-40 bg-black/5 overflow-hidden">
          <img
            src={item.imageUrl}
            alt={item.title}
            className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
          />
        </div>
      ) : null}
      <div className="p-5 space-y-3">
        {item.category ? (
          <div className="text-xs uppercase tracking-widest text-black/50">
            {item.category}
          </div>
        ) : null}
        <h3 className="text-base font-semibold text-black/90 leading-snug">
          {item.title}
        </h3>
        {item.date ? <div className="text-sm text-black/60">{item.date}</div> : null}
      </div>
    </article>
  );
}

