import React, { useState } from 'react';
import Container from '../components/Container';
import SectionHeading from '../components/SectionHeading';
import Breadcrumb from '../components/Breadcrumb';
import { contactLocations } from '../data/contactLocations';
import Reveal from '../components/Reveal';

export default function ContactPage() {
  const [firstName, setFirstName] = useState('');
  const [lastName, setLastName] = useState('');
  const [phone, setPhone] = useState('');
  const [email, setEmail] = useState('');
  const [message, setMessage] = useState('');

  return (
    <div>
      <section className="py-12 bg-black/[0.02]">
        <Reveal>
          <Container>
            <Breadcrumb crumbs={[{ label: 'Home', to: '/' }, { label: 'Contact Us' }]} />
            <div className="mt-6">
              <SectionHeading
                kicker="Contact Us"
                title="Get in touch"
                subtitle="Support and inquiries for orders, shipping, and returns."
              />
            </div>
          </Container>
        </Reveal>
      </section>

      <section className="py-14">
        <Reveal>
          <Container>
          <div className="grid lg:grid-cols-12 gap-10">
            <div className="lg:col-span-7 space-y-8">
              <div>
                <div className="text-xs tracking-widest uppercase text-black/50">
                  our offline store
                </div>
                <div className="mt-4 space-y-6">
                  {contactLocations.map((loc) => (
                    <div
                      key={loc.id}
                      className="rounded-3xl border border-black/5 bg-white p-7"
                    >
                      <div className="font-semibold text-black/90">
                        {loc.city}
                      </div>
                      <a
                        href="https://www.google.com/maps"
                        target="_blank"
                        rel="noreferrer"
                        className="mt-3 block text-sm text-black/60 hover:text-black transition-colors"
                      >
                        {loc.address}
                      </a>
                    </div>
                  ))}
                </div>
              </div>

              <div className="rounded-3xl border border-black/5 bg-white p-7 md:p-10">
                <div className="text-xs tracking-widest uppercase text-black/50">
                  reach us anytime
                </div>
                <div className="mt-4">
                  <div className="text-2xl font-semibold tracking-tight">Write to us</div>
                </div>

                <div className="mt-6 grid md:grid-cols-2 gap-5">
                  <label className="space-y-2">
                    <div className="text-sm font-semibold text-black/70">first name *</div>
                    <input
                      value={firstName}
                      onChange={(e) => setFirstName(e.target.value)}
                      className="w-full rounded-full border border-black/10 px-5 py-3 text-sm outline-none focus:border-black/30"
                      placeholder="Mr. Daniel"
                    />
                  </label>
                  <label className="space-y-2">
                    <div className="text-sm font-semibold text-black/70">last name</div>
                    <input
                      value={lastName}
                      onChange={(e) => setLastName(e.target.value)}
                      className="w-full rounded-full border border-black/10 px-5 py-3 text-sm outline-none focus:border-black/30"
                      placeholder="Scoot"
                    />
                  </label>
                  <label className="space-y-2">
                    <div className="text-sm font-semibold text-black/70">phone number</div>
                    <input
                      value={phone}
                      onChange={(e) => setPhone(e.target.value)}
                      className="w-full rounded-full border border-black/10 px-5 py-3 text-sm outline-none focus:border-black/30"
                      placeholder="+99 (0) *** ** ****"
                    />
                  </label>
                  <label className="space-y-2">
                    <div className="text-sm font-semibold text-black/70">
                      email address *
                    </div>
                    <input
                      value={email}
                      onChange={(e) => setEmail(e.target.value)}
                      className="w-full rounded-full border border-black/10 px-5 py-3 text-sm outline-none focus:border-black/30"
                      placeholder="example@email.com"
                    />
                  </label>
                </div>

                <label className="block mt-5 space-y-2">
                  <div className="text-sm font-semibold text-black/70">message</div>
                  <textarea
                    value={message}
                    onChange={(e) => setMessage(e.target.value)}
                    className="w-full min-h-[150px] rounded-3xl border border-black/10 px-5 py-4 text-sm outline-none focus:border-black/30"
                    placeholder="Write your enquiry..."
                  />
                </label>

                <div className="mt-8">
                  <button
                    type="button"
                    className="rounded-full bg-black text-white px-10 py-3 text-sm font-semibold hover:bg-black/90 transition-colors"
                  >
                    SUBMIT here
                  </button>
                </div>
              </div>
            </div>

            <aside className="lg:col-span-5">
              <div className="rounded-3xl overflow-hidden border border-black/5 bg-black/5 h-full">
                <img
                  src="https://demo-egenslab.b-cdn.net/html/ethics-html/preview/assets/image/home2/banner-product-image4.png"
                  alt="Contact map visual"
                  className="w-full h-full object-cover"
                />
              </div>
            </aside>
          </div>
          </Container>
        </Reveal>
      </section>
    </div>
  );
}

