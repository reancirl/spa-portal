const app = {
  title: process.env.VUE_APP_TITLE,
  tagline: process.env.VUE_APP_TAGLINE,
  copyright: process.env.VUE_APP_COPYRIGHT,
  email: process.env.VUE_APP_EMAIL,
  year: process.env.VUE_APP_YEAR,
  author: process.env.VUE_APP_AUTHOR,
  logo: process.env.VUE_APP_LOGO,
  locale: process.env.VUE_APP_LOCALE,
  settings: process.env.VUE_APP_SETTINGS,
  theme: JSON.parse(localStorage.getItem("theme:dark") || "{}") || process.env.VUE_APP_THEME,
};

export const BASE_URL = process.env.VUE_APP_API_BASE_URL;
export const GRANT_TYPE = process.env.VUE_APP_GRANT_TYPE;
export const CLIENT_ID = process.env.VUE_APP_CLIENT_ID;
export const CLIENT_SECRET = process.env.VUE_APP_CLIENT_SECRET;

export default app;
