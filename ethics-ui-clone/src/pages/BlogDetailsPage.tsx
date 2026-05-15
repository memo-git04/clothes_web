import React, { useMemo, useState } from 'react';
import { useParams } from 'react-router-dom';
import Container from '../components/Container';
import Breadcrumb from '../components/Breadcrumb';
import { blogPosts } from '../data/blogPosts';
import Reveal from '../components/Reveal';

export default function BlogDetailsPage() {
  const { slug } = useParams();
  const post = useMemo(
    () => blogPosts.find((p) => p.slug === slug),
    [slug],
  );

  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [message, setMessage] = useState('');

  if (!post) {
    return (
      <div className="max-w-7xl mx-auto px-4 py-14">
        <div className="text-2xl font-semibold">Post not found</div>
      </div>
    );
  }

  return (
    <div>
      <section className="py-12 bg-black/[0.02]">
        <Reveal>
          <Container>
            <Breadcrumb
              crumbs={[
                { label: 'Home', to: '/' },
                { label: 'Blog Grid', to: '/blog' },
                { label: post.title },
              ]}
            />

            <div className="mt-6">
              <h1 className="text-3xl md:text-4xl font-semibold tracking-tight text-black">
                {post.title}
              </h1>

              <div className="mt-3 flex flex-wrap items-center gap-3 text-sm text-black/60">
                <span className="rounded-full border border-black/10 px-3 py-1 bg-white">
                  {post.category}
                </span>
                <span>{post.date}</span>
                <span>By {post.author}</span>
              </div>
            </div>
          </Container>
        </Reveal>
      </section>

      <section className="py-14">
        <Reveal>
          <Container>
          <div className="grid lg:grid-cols-12 gap-10">
            <article className="lg:col-span-8 space-y-6">
              {post.imageUrl ? (
                <div className="rounded-3xl overflow-hidden border border-black/5 bg-white">
                  <img
                    src={post.imageUrl}
                    alt={post.title}
                    className="w-full h-[320px] object-cover"
                  />
                </div>
              ) : null}

              {post.paragraphs.map((p, idx) => (
                <p key={idx} className="text-black/70 leading-relaxed">
                  {p}
                </p>
              ))}

              {post.keyCharacteristics?.length ? (
                <div className="rounded-3xl border border-black/5 bg-white p-6 space-y-4">
                  <div className="font-semibold text-black/85">
                    Key Characteristics
                  </div>
                  <ul className="list-disc pl-5 space-y-2 text-black/65">
                    {post.keyCharacteristics.map((k) => (
                      <li key={k}>{k}</li>
                    ))}
                  </ul>
                </div>
              ) : null}

              {post.highlights?.length ? (
                <div className="flex flex-wrap gap-2">
                  {post.highlights.map((h) => (
                    <span
                      key={h}
                      className="text-xs rounded-full border border-black/10 px-3 py-2 text-black/60 bg-white"
                    >
                      {h}
                    </span>
                  ))}
                </div>
              ) : null}

              <div className="pt-2">
                <div className="flex flex-wrap gap-3 items-center">
                  <div className="font-semibold text-black/80">Share:</div>
                  {['Facebook', 'Twitter', 'LinkedIn'].map((s) => (
                    <button
                      key={s}
                      className="rounded-full border border-black/10 px-4 py-2 text-sm text-black/60 hover:text-black hover:border-black/20 transition-colors bg-white"
                      type="button"
                    >
                      {s}
                    </button>
                  ))}
                </div>
              </div>

              <div className="pt-6 border-t border-black/5">
                <div className="text-lg font-semibold text-black/85">
                  Comments ({post.comments.length.toString().padStart(2, '0')})
                </div>

                <div className="mt-6 space-y-5">
                  {post.comments.map((c) => (
                    <div key={c.id} className="rounded-3xl border border-black/5 bg-white p-6">
                      <div className="flex flex-wrap items-baseline gap-3">
                        <div className="font-semibold text-black/90">
                          {c.author}
                        </div>
                        <div className="text-sm text-black/60">{c.date}</div>
                      </div>
                      <p className="mt-3 text-black/65 leading-relaxed text-sm">
                        {c.text}
                      </p>

                      {c.replies?.length ? (
                        <div className="mt-4 pl-4 border-l border-black/10 space-y-4">
                          {c.replies.map((r) => (
                            <div
                              key={r.id}
                              className="rounded-2xl border border-black/5 bg-black/[0.02] p-4"
                            >
                              <div className="font-semibold text-black/85">
                                {r.author}
                              </div>
                              <div className="text-sm text-black/60">
                                {r.date}
                              </div>
                              <p className="mt-2 text-black/65 text-sm">
                                {r.text}
                              </p>
                            </div>
                          ))}
                        </div>
                      ) : null}

                      <button className="mt-4 text-sm font-semibold text-black/60 hover:text-black transition-colors">
                        Reply
                      </button>
                    </div>
                  ))}
                </div>

                <div className="mt-10 rounded-3xl border border-black/5 bg-white p-6 space-y-5">
                  <div className="text-lg font-semibold text-black/85">
                    Leave Your Comment:
                  </div>

                  <div className="grid md:grid-cols-2 gap-4">
                    <label className="space-y-2">
                      <div className="text-sm text-black/65 font-semibold">
                        Your Name*
                      </div>
                      <input
                        value={name}
                        onChange={(e) => setName(e.target.value)}
                        className="w-full rounded-full border border-black/10 px-5 py-3 text-sm outline-none focus:border-black/30"
                        placeholder="Your Name"
                      />
                    </label>
                    <label className="space-y-2">
                      <div className="text-sm text-black/65 font-semibold">
                        email address *
                      </div>
                      <input
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        className="w-full rounded-full border border-black/10 px-5 py-3 text-sm outline-none focus:border-black/30"
                        placeholder="email address"
                      />
                    </label>
                  </div>

                  <div>
                    <div className="text-sm text-black/65 font-semibold">
                      Please save My Name, Email Address for the next time I
                      comment.
                    </div>
                  </div>

                  <label className="space-y-2">
                    <div className="text-sm text-black/65 font-semibold">
                      Your Message :
                    </div>
                    <textarea
                      value={message}
                      onChange={(e) => setMessage(e.target.value)}
                      className="w-full min-h-[140px] rounded-3xl border border-black/10 px-5 py-4 text-sm outline-none focus:border-black/30"
                      placeholder="Write your message..."
                    />
                  </label>

                  <button
                    type="button"
                    className="primary-btn inline-flex items-center justify-center rounded-full bg-black text-white px-8 py-3 text-sm font-semibold hover:bg-black/90 transition-colors"
                  >
                    Post Comment
                  </button>
                </div>
              </div>
            </article>

            <aside className="lg:col-span-4 space-y-6">
              <div className="rounded-3xl border border-black/5 bg-white p-6">
                <div className="font-semibold text-black/85">Admin</div>
                <div className="mt-4 text-sm text-black/65">Mr. Daniel Scoot</div>
              </div>

              <div className="rounded-3xl border border-black/5 bg-white p-6">
                <div className="font-semibold text-black/85">Tag:</div>
                <div className="mt-4 flex flex-wrap gap-2">
                  {post.category ? (
                    <span className="text-xs px-3 py-2 rounded-full border border-black/10 text-black/60 bg-white">
                      {post.category}
                    </span>
                  ) : null}
                  <span className="text-xs px-3 py-2 rounded-full border border-black/10 text-black/60 bg-white">
                    Highlights
                  </span>
                </div>
              </div>

              <div className="rounded-3xl border border-black/5 bg-white p-6">
                <div className="font-semibold text-black/85">Recent posts</div>
                <div className="mt-4 space-y-3">
                  {blogPosts
                    .filter((p) => p.slug !== post.slug)
                    .slice(0, 3)
                    .map((p) => (
                      <div key={p.slug} className="text-sm text-black/60">
                        {p.title}
                      </div>
                    ))}
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

