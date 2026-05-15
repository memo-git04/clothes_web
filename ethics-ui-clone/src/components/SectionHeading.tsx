import React from 'react';

export default function SectionHeading({
  kicker,
  title,
  subtitle,
}: {
  kicker?: string;
  title: string;
  subtitle?: string;
}) {
  return (
    <div className="space-y-3">
      {kicker ? (
        <div className="text-xs tracking-widest uppercase text-black/60">
          {kicker}
        </div>
      ) : null}
      <h2 className="text-3xl md:text-4xl font-semibold tracking-tight">
        {title}
      </h2>
      {subtitle ? <p className="text-black/60 max-w-2xl">{subtitle}</p> : null}
    </div>
  );
}

