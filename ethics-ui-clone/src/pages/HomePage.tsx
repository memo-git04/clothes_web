import React from 'react';
import Container from '../components/Container';
import SectionHeading from '../components/SectionHeading';
import ProductCard, { ProductCardModel } from '../components/cards/ProductCard';
import TestimonialCard, {
  TestimonialModel,
} from '../components/cards/TestimonialCard';
import BlogTeaserCard, {
  BlogTeaserModel,
} from '../components/cards/BlogTeaserCard';
import NewsletterSection from '../components/sections/NewsletterSection';
import Reveal from '../components/Reveal';

export default function HomePage() {
  const products: ProductCardModel[] = [
    {
      title: 'Stylish Relaxed Fit Shirt',
      price: '$100.00',
      compareAtPrice: '$123.00',
      badge: '23% off Hot deal',
      colors: ['Brown', 'Lavender', 'Cyan'],
    },
    {
      title: 'Ultimate Comfort & Trendy Design',
      price: '$300.00',
      compareAtPrice: '$345.00',
      badge: '23% off Hot deal',
      colors: ['Brown', 'Persian Red', 'Yellow', 'Amber'],
    },
    {
      title: 'Cozy Chic Knit Sweater',
      price: '$200.00',
      compareAtPrice: '$245.00',
      badge: '23% off Hot deal',
      colors: ['Rhino', 'Lavender', 'Black', 'Claret'],
    },
    {
      title: 'Ultimate Comfort & Trendy Design',
      price: '$300.00',
      compareAtPrice: '$345.00',
      colors: ['Brown', 'Persian Red', 'Yellow', 'Amber'],
    },
    {
      title: 'Stylish Relaxed Fit Shirt',
      price: '$100.00',
      compareAtPrice: '$123.00',
      colors: ['Brown', 'Lavender', 'Cyan'],
    },
    {
      title: 'Cozy Chic Knit Sweater',
      price: '$200.00',
      compareAtPrice: '$245.00',
      colors: ['Rhino', 'Lavender', 'Black', 'Claret'],
    },
  ];

  const testimonials: TestimonialModel[] = [
    {
      quote:
        '“I was recommended snaga from a dear friendest onest Gives energy, strength & mostly youm motivationt goint and WOW!!!”',
      name: 'Jayden Carter',
      role: 'Fashion designer',
    },
    {
      quote:
        '“I was recommended snaga from a dear friendest onest Gives energy, strength & mostly youm motivationt goint and WOW!!!”',
      name: 'Colton Roman',
      role: 'Fashion designer',
    },
    {
      quote:
        '“I was recommended snaga from a dear friendest onest Gives energy, strength & mostly youm motivationt goint and WOW!!!”',
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
      {/* Hero */}
      <section className="relative overflow-hidden">
        <div className="absolute inset-0 bg-gradient-to-b from-black/5 via-white to-white" />
        <Reveal>
          <Container className="relative pt-12 pb-10 md:pt-16 md:pb-14">
          <div className="grid lg:grid-cols-12 gap-10 items-center">
            <div className="lg:col-span-7">
              <div className="inline-flex items-center rounded-full border border-black/10 px-4 py-2 text-xs tracking-widest uppercase text-black/60">
                Summer Collection
              </div>
              <h1 className="mt-5 text-4xl md:text-5xl font-semibold tracking-tight">
                Discover your style with our trendsetting fashion
              </h1>
              <p className="mt-4 text-black/60 max-w-xl">
                Elite Fashion House — crafting a unique fashion experience with
                modern design and fast delivery.
              </p>
              <div className="mt-7 flex flex-col sm:flex-row gap-3">
                <button className="rounded-full bg-black text-white px-8 py-3 text-sm font-semibold hover:bg-black/90 transition-colors">
                  Shop Now
                </button>
                <button className="rounded-full border border-black/10 px-8 py-3 text-sm font-semibold hover:border-black/20 hover:text-black transition-colors bg-white/80">
                  Explore Collection
                </button>
              </div>
            </div>
            <div className="lg:col-span-5">
              <div className="relative rounded-3xl overflow-hidden border border-black/5 bg-black/5">
                <img
                  src="https://demo-egenslab.b-cdn.net/html/ethics-html/preview/assets/image/home2/banner-product-image.jpg"
                  alt="Summer Collection"
                  className="w-full h-[360px] md:h-[420px] object-cover"
                />
                <div className="absolute left-6 bottom-6 rounded-2xl bg-white/90 border border-black/10 px-5 py-4">
                  <div className="text-xs tracking-widest uppercase text-black/50">
                    50% Off Now
                  </div>
                  <div className="mt-1 font-semibold text-black">
                    Embrace the Sun in your Style
                  </div>
                </div>
              </div>
            </div>
          </div>
          </div>
        </Container>
        </Reveal>
      </section>

      {/* Promo features */}
      <section className="py-10">
        <Reveal>
          <Container>
          <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            {[
              ['Fast Delivery', 'Delivery in 24 hours max!'],
              ['Safe Payment', '100% Secure Payment'],
              ['Online Discount', 'Add Multi-Buy Discount'],
              ['Help Center', 'Dedicated 24/7 Support'],
            ].map(([title, desc]) => (
              <div
                key={title}
                className="rounded-2xl bg-white border border-black/5 p-6 transition-transform duration-300 hover:-translate-y-1"
              >
                <div className="font-semibold">{title}</div>
                <div className="mt-1 text-sm text-black/60">{desc}</div>
              </div>
            ))}
          </div>
          </Container>
        </Reveal>
      </section>

      {/* Best Selling */}
      <section className="py-12">
        <Reveal>
          <Container>
          <SectionHeading
            kicker="Best Selling Fashion"
            title="Discover our best selling essentials"
            subtitle="Curated just for you! Elevate your wardrobe with must-have pieces."
          />
          <div className="mt-10 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {products.map((p) => (
              <ProductCard key={p.title + (p.price ?? '')} product={p} />
            ))}
          </div>
          </Container>
        </Reveal>
      </section>

      {/* Shop by categories */}
      <section className="py-12 bg-black/[0.02]">
        <Reveal>
          <Container>
          <SectionHeading
            kicker="Shop by categories"
            title="Explore by category"
            subtitle="From chic dresses to sophisticated accessories."
          />
          <div className="mt-10 grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            {['Bottoms', 'Tops', 'Bags', 'Jewelry', 'Sunglasses', 'Shoes'].map(
              (c) => (
                <button
                  key={c}
                  className="group text-left rounded-2xl border border-black/5 bg-white p-5 hover:border-black/15 hover:bg-white transition-colors"
                >
                  <div className="text-sm font-medium">{c}</div>
                  <div className="mt-2 text-xs text-black/55 group-hover:text-black/70 transition-colors">
                    Shop now →
                  </div>
                </button>
              ),
            )}
          </div>
          </Container>
        </Reveal>
      </section>

      {/* Exclusive collection */}
      <section className="py-14">
        <Reveal>
          <Container>
          <div className="grid lg:grid-cols-12 gap-8 items-stretch">
            <div className="lg:col-span-5">
              <div className="rounded-3xl overflow-hidden border border-black/5 bg-black/5 h-full">
                <img
                  src="https://demo-egenslab.b-cdn.net/html/ethics-html/preview/assets/image/home2/banner-product-image2.jpg"
                  alt="Exclusive collection"
                  className="w-full h-full object-cover"
                />
              </div>
            </div>
            <div className="lg:col-span-7">
              <SectionHeading
                kicker="Exclusive fashion collection"
                title="Exquisite Jewelry Collection"
                subtitle="Chic Urban Elegance — explore our diverse range of fashion categories."
              />
              <div className="mt-8 grid sm:grid-cols-2 gap-4">
                {[
                  'Megi Dress',
                  'oversize coat',
                  'Sunglass',
                  'Jacket',
                  'Co-ord',
                  'Headpiece',
                  'Bag',
                ].map((t) => (
                  <div
                    key={t}
                    className="rounded-2xl border border-black/5 bg-white px-5 py-4 text-sm font-medium text-black/80 hover:border-black/15 transition-colors"
                  >
                    {t}
                  </div>
                ))}
              </div>
              <div className="mt-8 flex flex-wrap gap-3">
                <button className="rounded-full border border-black/10 px-6 py-3 text-sm font-semibold hover:border-black/20 hover:text-black transition-colors bg-white/80">
                  Shop Jewelry
                </button>
                <button className="rounded-full bg-black text-white px-6 py-3 text-sm font-semibold hover:bg-black/90 transition-colors">
                  View All
                </button>
              </div>
            </div>
          </div>
          </Container>
        </Reveal>
      </section>

      {/* Testimonial */}
      <section className="py-14 bg-black/[0.02]">
        <Reveal>
          <Container>
          <SectionHeading
            kicker="Testimonial"
            title="Our happy customers"
            subtitle="What customers say about us"
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
            kicker="Our fashion blog"
            title="Fashion news & trends"
            subtitle="Insights and guides to help you dress better every day."
          />
          <div className="mt-10 grid md:grid-cols-3 gap-6">
            {blogTeasers.map((b) => (
              <BlogTeaserCard key={b.title} item={b} />
            ))}
          </div>
          </Container>
        </Reveal>
      </section>

      {/* Newsletter */}
      <section className="py-14">
        <Reveal>
          <Container>
            <NewsletterSection />
          </Container>
        </Reveal>
      </section>
    </div>
  );
}

