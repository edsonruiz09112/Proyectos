/** @type {import('next').NextConfig} */
const nextConfig = {
  reactStrictMode: true,
  async rewrites() {
    return [
      {
        // Cuando el frontend pida /api/proxy/...
        source: '/api/proxy/:path*',
        // Next.js lo redirigirá secretamente al backend de Python
        destination: 'https://pysearch.onrender.com/:path*',
      },
    ];
  },
};

module.exports = nextConfig;