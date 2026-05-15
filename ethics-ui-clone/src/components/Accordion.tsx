import React, { useId, useMemo, useState } from 'react';

export type AccordionItemModel = {
  id: string;
  title: string;
  content: React.ReactNode;
};

export default function Accordion({
  items,
  defaultOpenId,
}: {
  items: AccordionItemModel[];
  defaultOpenId?: string;
}) {
  const uid = useId();
  const initial = defaultOpenId ?? items[0]?.id;
  const [openId, setOpenId] = useState<string | null>(initial ?? null);

  const map = useMemo(() => new Map(items.map((i) => [i.id, i])), [items]);

  return (
    <div className="space-y-3">
      {items.map((item) => {
        const isOpen = openId === item.id;
        const titleId = `${uid}-title-${item.id}`;
        const panelId = `${uid}-panel-${item.id}`;

        return (
          <div key={item.id} className="rounded-2xl border border-black/5 bg-white overflow-hidden">
            <button
              type="button"
              className="w-full px-5 py-4 flex items-center justify-between gap-4 text-left"
              onClick={() => setOpenId(isOpen ? null : item.id)}
              aria-expanded={isOpen}
              aria-controls={panelId}
              id={titleId}
            >
              <div className="font-medium text-black/80">{item.title}</div>
              <div
                className={[
                  'h-9 w-9 rounded-full border border-black/10 flex items-center justify-center text-sm transition-transform',
                  isOpen ? 'rotate-45' : 'rotate-0',
                ].join(' ')}
              >
                +
              </div>
            </button>

            <div
              id={panelId}
              role="region"
              aria-labelledby={titleId}
              className={[
                'px-5 pb-4 transition-[max-height,opacity] duration-300 ease-in-out',
                isOpen ? 'opacity-100' : 'opacity-0',
                isOpen ? 'max-h-96' : 'max-h-0',
              ].join(' ')}
            >
              <div className="text-sm text-black/60">{item.content}</div>
            </div>
          </div>
        );
      })}
    </div>
  );
}

