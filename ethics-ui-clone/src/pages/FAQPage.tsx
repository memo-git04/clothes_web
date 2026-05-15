import React, { useState } from 'react';
import Container from '../components/Container';
import SectionHeading from '../components/SectionHeading';
import Breadcrumb from '../components/Breadcrumb';
import Accordion from '../components/Accordion';
import { faqItems } from '../data/faqItems';
import Reveal from '../components/Reveal';

export default function FAQPage() {
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
            <Breadcrumb crumbs={[{ label: 'Home', to: '/' }, { label: 'Faq' }]} />
            <div className="mt-6">
              <SectionHeading
                kicker="Faq"
                title="Frequently asked questions"
                subtitle="Answers to common questions about shipping, returns, and support."
              />
            </div>
          </Container>
        </Reveal>
      </section>

      <section className="py-14">
        <Reveal>
          <Container>
          <Accordion
            items={faqItems.map((f) => ({
              id: f.id,
              title: f.question,
              content: <span>{f.answer}</span>,
            }))}
          />

          <div className="mt-14 rounded-3xl border border-black/5 bg-white p-7 md:p-10">
            <SectionHeading
              kicker="Ask us anytime"
              title="Any things"
              subtitle="Send us a message and we’ll get back to you."
            />

            <div className="mt-8 grid md:grid-cols-2 gap-5">
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
                className="w-full min-h-[140px] rounded-3xl border border-black/10 px-5 py-4 text-sm outline-none focus:border-black/30"
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
          </Container>
        </Reveal>
      </section>
    </div>
  );
}

