import React from 'react';
import Container from '../components/Container';
import SectionHeading from '../components/SectionHeading';
import TestimonialCard, { TestimonialModel } from '../components/cards/TestimonialCard';
import BlogTeaserCard, { BlogTeaserModel } from '../components/cards/BlogTeaserCard';
import Reveal from '../components/Reveal';

export default function AboutPage() {
  const values = [
    { num: '1.', title: 'Quality', desc: 'We source the finest materials and partner with skilled artisans.' },
    { num: '2.', title: 'Sustainability', desc: 'We are dedicated to promoting a more sustainable fashion industry.' },
    { num: '3.', title: 'Inclusivity', desc: 'Fashion should be accessible to all. We celebrate diversity in style.' },
    { num: '4.', title: 'Innovation', desc: 'We stay ahead of the curve by constantly evolving and innovating.' },
  ];

  const testimonials: TestimonialModel[] = [
    {
      quote:
        '“I was recommended snaga from a dear friendest onest Gives energy, strength & mostly youm motivationt goint”',
      name: 'Jayden Carter',
      role: 'Fashion designer',
    },
    {
      quote:
        '“I was recommended snaga from a dear friendest onest Gives energy, strength & mostly youm motivationt goint”',
      name: 'Colton Roman',
      role: 'Fashion designer',
    },
    {
      quote:
        '“I was recommended snaga from a dear friendest onest Gives energy, strength & mostly youm motivationt goint”',
      name: 'Lincoln Miles',
      role: 'Fashion designer',
    },
  ];

  const blogTeasers: BlogTeaserModel[] = [
    {
      title: 'Winter Fashion Forecast: What’s Hot This Season',
      date: '02 May, 2024',
      category: 'Fashion Trends',
      imageUrl:
        'https://demo-egenslab.b-cdn.net/html/ethics-html/preview/assets/image/home2/home2-blog-image.jpg',
    },
    {
      title: 'The Ultimate Guide to Accessorizing Your Outfits',
      date: '03 May, 2024',
      category: 'Style Guides',
      imageUrl:
        'https://demo-egenslab.b-cdn.net/html/ethics-html/preview/assets/image/home2/home2-blog-image2.jpg',
    },
    {
      title: '‘Street Style’ Trends We’re Loving Right Now',
      date: '06 May, 2024',
      category: 'Trendspotting',
      imageUrl:
        'https://demo-egenslab.b-cdn.net/html/ethics-html/preview/assets/image/home2/home2-blog-image3.jpg',
    },
  ];

  return (
    <div>
      {/* About hero */}
      <section className="py-14 bg-black/[0.02]">
        <Reveal>
        <Container>
          <SectionHeading
            kicker="About us"
            title="Welcome to Ethics, where style meets innovation"
            subtitle="Founded in [Year], [Your Brand Name] emerged from a passion for fashion and a desire to bring unique, high-quality clothing to the forefront."
          />
          <div className="mt-8 grid lg:grid-cols-12 gap-8 items-start">
            <div className="lg:col-span-7 text-black/70 leading-relaxed">
              <p>
                Our journey began with a simple mission: to make fashion accessible, exciting, and inclusive for everyone. What started as a small collection
                has blossomed into a diverse and expansive range of apparel, accessories, and footwear.
              </p>
              <p className="mt-4">
                We meticulously curate each piece to help you express your unique style with confidence.
              </p>
            </div>
            <div className="lg:col-span-5">
              <div className="rounded-3xl overflow-hidden border border-black/5 bg-white">
                <img
                  src="https://demo-egenslab.b-cdn.net/html/ethics-html/preview/assets/image/home2/banner-product-image3.jpg"
                  alt="Ethics fashion"
                  className="w-full h-64 object-cover"
                />
                <div className="p-6">
                  <div className="text-sm text-black/60">We have Many Brands & 20+ Trusted Partner</div>
                  <div className="mt-2 font-semibold">Trusted by customers worldwide</div>
                </div>
              </div>
            </div>
          </div>
        </Container>
        </Reveal>
      </section>

      {/* Values */}
      <section className="py-14">
        <Reveal>
        <Container>
          <SectionHeading
            kicker="Our Values"
            title="What we stand for"
            subtitle="Quality, sustainability, inclusivity, and innovation — always."
          />
          <div className="mt-10 grid sm:grid-cols-2 gap-6">
            {values.map((v) => (
              <div key={v.title} className="rounded-3xl border border-black/5 bg-white p-7">
                <div className="text-xs tracking-widest uppercase text-black/50">
                  {v.num} {v.title}
                </div>
                <div className="mt-3 text-sm text-black/70 leading-relaxed">{v.desc}</div>
              </div>
            ))}
          </div>
        </Container>
        </Reveal>
      </section>

      {/* Testimonials */}
      <section className="py-14 bg-black/[0.02]">
        <Reveal>
        <Container>
          <SectionHeading
            kicker="Testimonial"
            title="our happy customers"
            subtitle="Real feedback from people who love our fashion."
          />
          <div className="mt-10 grid md:grid-cols-3 gap-6">
            {testimonials.map((t) => (
              <TestimonialCard key={t.name} item={t} />
            ))}
          </div>
        </Container>
        </Reveal>
      </section>

      {/* Blog preview */}
      <section className="py-14">
        <Reveal>
        <Container>
          <SectionHeading
            kicker="OUR FASHION BLOG"
            title="Insights and guides"
            subtitle="Explore the latest fashion trends and style tips."
          />
          <div className="mt-10 grid md:grid-cols-3 gap-6">
            {blogTeasers.map((b) => (
              <BlogTeaserCard key={b.title} item={b} />
            ))}
          </div>
        </Container>
        </Reveal>
      </section>

      {/* Instagram feed */}
      <section className="py-14 bg-black/[0.02]">
        <Reveal>
        <Container>
          <SectionHeading
            kicker="INSTAGRAM FEED"
            title="Follow our style"
            subtitle="A curated look at our latest collections."
          />
          <div className="mt-10 grid grid-cols-3 gap-3">
            {[
              'https://demo-egenslab.b-cdn.net/html/ethics-html/preview/assets/image/home1/gallery-image.png',
              'https://demo-egenslab.b-cdn.net/html/ethics-html/preview/assets/image/home1/gallery-image2.png',
              'https://demo-egenslab.b-cdn.net/html/ethics-html/preview/assets/image/home1/gallery-image3.png',
              'https://demo-egenslab.b-cdn.net/html/ethics-html/preview/assets/image/home1/gallery-image2.png',
              'https://demo-egenslab.b-cdn.net/html/ethics-html/preview/assets/image/home1/gallery-image.png',
              'https://demo-egenslab.b-cdn.net/html/ethics-html/preview/assets/image/home1/gallery-image3.png',
            ].map((src, idx) => (
              <div key={src + idx} className="aspect-square overflow-hidden rounded-2xl bg-white border border-black/5">
                <img src={src} alt="Instagram item" className="w-full h-full object-cover hover:scale-105 transition-transform duration-500" />
              </div>
            ))}
          </div>
        </Container>
        </Reveal>
      </section>
    </div>
  );
}

