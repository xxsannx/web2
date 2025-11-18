// eslint.config.js
export default [
  {
    files: ['*.js', '*.ts'],
    languageOptions: {
      ecmaVersion: 'latest',
      sourceType: 'module'
    },
    rules: {
      'no-unused-vars': 'warn',
      'no-console': 'off',
      'semi': ['warn', 'always'],
      'quotes': ['warn', 'single']
    }
  }
];
