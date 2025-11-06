module.exports = {
  ci: {
    collect: {
      startServerCommand: 'php artisan serve --port=8000',
      url: ['http://localhost:8000'],
      numberOfRuns: 3,
    },
    assert: {
      assertions: {
        'categories:performance': ['warn', {minScore: 0.8}],
        'categories:accessibility': ['error', {minScore: 0.9}],
        'categories:best-practices': ['warn', {minScore: 0.8}],
        'categories:seo': ['warn', {minScore: 0.8}],
      },
    },
    upload: {
      target: 'filesystem',
      outputDir: 'lighthouse-reports',
    },
  },
};
