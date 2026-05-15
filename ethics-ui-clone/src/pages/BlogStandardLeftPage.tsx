import React from 'react';
import Container from '../components/Container';
import SectionHeading from '../components/SectionHeading';
import { blogPosts } from '../data/blogPosts';
import Breadcrumb from '../components/Breadcrumb';
import Reveal from '../components/Reveal';

export default function BlogStandardLeftPage() {
  const categories = Array.from(new Set(blogPosts.map((p) => p.category)));

  return (
    <div>
      <section className="py-12 bg-black/[0.02]">
        <Reveal>
          <Container>
            <Breadcrumb
              crumbs={[
                { label: 'Home', to: '/' },
                { label: 'Blog Standard' },
              ]}
            />
            <div className="mt-6">
              <SectionHeading
                kicker="Blog Standard"
                title="Blog"
                subtitle="Latest posts and category sidebar."
              />
            </div>
          </Container>
        </Reveal>
      </section>

      <section className="py-14">
        <Reveal>
          <Container>
          <div className="grid lg:grid-cols-12 gap-10">
            <div className="lg:col-span-8">
              <div className="space-y-6">
                {blogPosts.map((p) => (
                  <div key={p.slug} className="rounded-3xl overflow-hidden border border-black/5 bg-white">
                    <div className="grid sm:grid-cols-5">
                      <div className="sm:col-span-2 h-44 sm:h-full bg-black/5">
                        {p.imageUrl ? (
                          <img
                            src={p.imageUrl}
                            alt={p.title}
                            className="w-full h-full object-cover"
                          />
                        ) : null}
                      </div>
                      <div className="sm:col-span-3 p-6 flex flex-col justify-between gap-4">
                        <div>
                          <div className="text-xs uppercase tracking-widest text-black/50">
                            {p.category}
                          </div>
                          <div className="mt-3 text-lg font-semibold text-black/90">
                            {p.title}
                          </div>
                          <div className="mt-2 text-sm text-black/60">{p.date}</div>
                        </div>
                        <div className="flex items-center justify-between">
                          <button className="text-sm font-semibold text-black/70 hover:text-black transition-colors">
                            Read more
                          </button>
                          <div className="text-xs text-black/40">/</div>
                        </div>
                      </div>
                    </div>
                  </div>
                ))}
              </div>
            </div>

            <aside className="lg:col-span-4">
              <div className="space-y-6">
                <div className="rounded-3xl border border-black/5 bg-white p-6">
                  <div className="text-sm font-semibold">Category</div>
                  <div className="mt-4 flex flex-col gap-2">
                    {categories.map((c) => (
                      <a key={c} href="#/" className="text-sm text-black/60 hover:text-black transition-colors">
                        {c.toLowerCase()}
                      </a>
                    ))}
                  </div>
                </div>

                <div className="rounded-3xl border border-black/5 bg-white p-6">
                  <div className="text-sm font-semibold">Tag:</div>
                  <div className="mt-4 flex flex-wrap gap-2">
                    {categories.map((c) => (
                      <span
                        key={c}
                        className="text-xs px-3 py-2 border border-black/10 rounded-full text-black/60"
                      >
                        {c}
                      </span>
                    ))}
                  </div>
                </div>

                <div className="rounded-3xl border border-black/5 bg-white p-6">
                  <div className="text-sm font-semibold">Search</div>
                  <input
                    placeholder="Search..."
                    className="mt-4 w-full rounded-full border border-black/10 px-5 py-3 text-sm outline-none focus:border-black/30"
                  />
                </div>

                <div className="rounded-3xl border border-black/5 bg-white p-6">
                  <div className="text-sm font-semibold">Latest blog</div>
                  <div className="mt-4 space-y-3">
                    {blogPosts.slice(0, 4).map((p) => (
                      <a key={p.slug} href={`#/blog/${p.slug}`} className="block text-sm text-black/60 hover:text-black transition-colors">
                        {p.title}
                      </a>
                    ))}
                  </div>
                </div>
              </div>
            </aside>
          </div>
          </Container>
        </Reveal>
      </section>
    </div>
  );
}

