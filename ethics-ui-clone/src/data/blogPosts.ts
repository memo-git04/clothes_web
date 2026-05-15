export type BlogComment = {
  id: string;
  author: string;
  date: string;
  text: string;
  replies?: BlogComment[];
};

export type BlogPost = {
  slug: string;
  title: string;
  date: string;
  category: string;
  imageUrl?: string;
  author: string;
  summary: string;
  paragraphs: string[];
  keyCharacteristics?: string[];
  highlights?: string[];
  comments: BlogComment[];
};

export const blogPosts: BlogPost[] = [
  {
    slug: 'winter-fashion-forecast',
    title: 'Winter Fashion Forecast: What’s Hot This Season',
    date: '02 May, 2024',
    category: 'Fashion Trends',
    imageUrl:
      'https://demo-egenslab.b-cdn.net/html/ethics-html/preview/assets/image/home2/home2-blog-image.jpg',
    author: 'Mr. Daniel Scoot',
    summary:
      'A winter look at what will define the season, with curated style tips and key characteristics to guide your choices.',
    paragraphs: [
      'As we reflect on this achievement, we look forward to continuing our journey of digital innovation, creating transformative solutions, and shaping the future of the digital landscape.',
      'This milestone is a testament to the hard work, creativity, and dedication of our incredible team and the unwavering support from our clients and partners.',
    ],
    keyCharacteristics: [
      'Residential real estate involves properties used for housing and includes single-family homes.',
      'With a focus on technology, digital agencies have teams skilled in web development.',
      'Digital agencies explore innovative strategies and technologies to keep campaigns fresh.',
      'The digital agency landscape is highly competitive, requiring agencies to differentiate themselves.',
    ],
    highlights: ['Highlights from New York Fashion Week'],
    comments: [
      {
        id: 'c1',
        author: 'Mr. Bowmik Haldar',
        date: '02 June, 2024',
        text: 'Organization decides to seek consulting services to address a particular issue or to achieve specific objectives.',
        replies: [
          {
            id: 'c1r1',
            author: 'Reply Author',
            date: '02 June, 2024',
            text: 'Consultants may provide hands-on support during the implementation phase, offering guidance, training, and assistance.',
          },
        ],
      },
      {
        id: 'c2',
        author: 'Jacoline Juie',
        date: '02 June, 2024',
        text: 'Consultants may provide hands-on support during the implementation phase, offering guidance, training, and assistance.',
      },
    ],
  },
  {
    slug: 'accessorizing-your-outfits',
    title: 'The Ultimate Guide to Accessorizing Your Outfits',
    date: '03 May, 2024',
    category: 'Style Guides',
    imageUrl:
      'https://demo-egenslab.b-cdn.net/html/ethics-html/preview/assets/image/home2/home2-blog-image2.jpg',
    author: 'Admin',
    summary:
      'Learn how to pair statement pieces with everyday basics and build a cohesive look in minutes.',
    paragraphs: [
      'Accessorizing is the fastest way to refresh your style without changing your wardrobe.',
      'Start with one focal point—then balance shape, color, and scale across the rest of your outfit.',
    ],
    highlights: ['Tag: Fashion Trends'],
    comments: [],
  },
  {
    slug: 'street-style-trends',
    title: '‘Street Style’ Trends We’re Loving Right Now',
    date: '06 May, 2024',
    category: 'Trendspotting',
    imageUrl:
      'https://demo-egenslab.b-cdn.net/html/ethics-html/preview/assets/image/home2/home2-blog-image3.jpg',
    author: 'Admin',
    summary:
      'A quick roundup of street-inspired outfits and styling tricks that translate to your daily life.',
    paragraphs: [
      'Street style is about effortless layering and personal expression.',
      'Look for contrasts—soft textures with structured silhouettes—and repeat a color for cohesion.',
    ],
    highlights: ['Tag: Trendspotting'],
    comments: [],
  },
];

