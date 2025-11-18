// eslint.config.js
export default {
  root: true,
  env: {
    browser: true,
    node: true,
    es2021: true,
  },
  parserOptions: {
    ecmaVersion: "latest",
    sourceType: "module",
  },
  extends: [
    "eslint:recommended",
    "plugin:vue/vue3-recommended"
  ],
  rules: {
    "no-unused-vars": "warn",
    "no-console": "off"
  },
  overrides: [
    {
      files: ["*.vue"],
      parser: "vue-eslint-parser"
    }
  ]
};
