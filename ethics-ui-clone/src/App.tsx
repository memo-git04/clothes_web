import React from 'react';
import { Navigate, Route, Routes } from 'react-router-dom';
import PageLayout from './layouts/PageLayout';
import HomePage from './pages/HomePage';
import AboutPage from './pages/AboutPage';
import BlogGridPage from './pages/BlogGridPage';
import BlogStandardLeftPage from './pages/BlogStandardLeftPage';
import BlogDetailsPage from './pages/BlogDetailsPage';
import FAQPage from './pages/FAQPage';
import ContactPage from './pages/ContactPage';

export default function App() {
  return (
    <Routes>
      <Route element={<PageLayout />}>
        <Route path="/" element={<HomePage />} />
        <Route path="/about" element={<AboutPage />} />
        <Route path="/blog" element={<BlogGridPage />} />
        <Route path="/blog-standard" element={<BlogStandardLeftPage />} />
        <Route path="/blog/:slug" element={<BlogDetailsPage />} />
        <Route path="/faq" element={<FAQPage />} />
        <Route path="/contact" element={<ContactPage />} />

        <Route path="*" element={<Navigate to="/" replace />} />
      </Route>
    </Routes>
  );
}

