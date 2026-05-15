import React from 'react';
import Container from '../components/Container';
import SectionHeading from '../components/SectionHeading';
import BlogTeaserCard from '../components/cards/BlogTeaserCard';
import { blogPosts } from '../data/blogPosts';
import Breadcrumb from '../components/Breadcrumb';
import { Link } from 'react-router-dom';
import Reveal from '../components/Reveal';

export default function BlogGridPage() {
  return (
    <div>
      <section className="py-12 bg-black/[0.02]">
        <Reveal>
          <Container>
            <Breadcrumb crumbs={[{ label: 'Home', to: '/' }, { label: 'Blog Grid' }]} />
            <div className="mt-6">
              <SectionHeading
                kicker="Blog Grid"
                title="Our fashion blog"
                subtitle="Discover fashion news, insights and guides."
              />
            </div>
          </Container>
        </Reveal>
      </section>

      <section className="py-14">
        <Reveal>
          <Container>
            <div className="grid md:grid-cols-3 gap-6">
              {blogPosts.map((p) => (
                <Link key={p.slug} to={`/blog/${p.slug}`} className="block">
                  <BlogTeaserCard
                    item={{
                      title: p.title,
                      date: p.date,
                      category: p.category,
                      imageUrl: p.imageUrl,
                    }}
                  />
                </Link>
              ))}
            </div>

            <div className="mt-10 flex items-center justify-between">
              <button className="px-6 py-3 rounded-full border border-black/10 hover:border-black/20 transition-colors text-sm font-semibold text-black/70">
                prev
              </button>
              <button className="px-6 py-3 rounded-full bg-black text-white hover:bg-black/90 transition-colors text-sm font-semibold">
                next
              </button>
            </div>
          </Container>
        </Reveal>
      </section>
    </div>
  );
}

