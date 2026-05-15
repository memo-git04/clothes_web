import React from 'react';
import { Link } from 'react-router-dom';

type Crumb = { label: string; to?: string };

export default function Breadcrumb({ crumbs }: { crumbs: Crumb[] }) {
  return (
    <nav aria-label="Breadcrumb" className="text-sm text-black/50">
      <ol className="flex flex-wrap items-center gap-2">
        {crumbs.map((c, idx) => {
          const isLast = idx === crumbs.length - 1;
          return (
            <li key={c.label} className="flex items-center gap-2">
              {c.to && !isLast ? (
                <Link to={c.to} className="hover:text-black transition-colors">
                  {c.label}
                </Link>
              ) : (
                <span className={isLast ? 'text-black/70' : undefined}>
                  {c.label}
                </span>
              )}
              {!isLast ? <span aria-hidden="true">/</span> : null}
            </li>
          );
        })}
      </ol>
    </nav>
  );
}

