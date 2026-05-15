import React from 'react';

export type ProductCardModel = {
  title: string;
  price?: string;
  compareAtPrice?: string;
  badge?: string;
  colors?: string[];
};

export default function ProductCard({ product }: { product: ProductCardModel }) {
  return (
    <div className="group border border-black/5 rounded-2xl overflow-hidden bg-white transition-transform duration-300 hover:-translate-y-1">
      <div className="h-56 bg-gradient-to-br from-black/5 to-black/0 flex items-end p-4">
        {product.badge ? (
          <div className="inline-flex items-center rounded-full bg-black/90 text-white text-xs px-3 py-1">
            {product.badge}
          </div>
        ) : null}
      </div>

      <div className="p-5 space-y-3">
        <div className="text-sm font-medium text-black/90">{product.title}</div>

        <div className="flex items-baseline gap-2">
          {product.compareAtPrice ? (
            <div className="text-black/30 line-through text-sm">
              {product.compareAtPrice}
            </div>
          ) : null}
          {product.price ? <div className="text-sm font-semibold">{product.price}</div> : null}
        </div>

        {product.colors?.length ? (
          <ul className="flex flex-wrap gap-2 text-xs text-black/60">
            {product.colors.slice(0, 4).map((c) => (
              <li key={c} className="rounded-full border border-black/10 px-2 py-1 bg-black/[0.02]">
                {c}
              </li>
            ))}
          </ul>
        ) : null}

        <div className="pt-2 flex items-center justify-between">
          <button className="text-xs font-medium text-black/70 hover:text-black transition-colors">
            View
          </button>
          <button className="text-xs font-medium text-white bg-black rounded-full px-4 py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
            Add to cart
          </button>
        </div>
      </div>
    </div>
  );
}

