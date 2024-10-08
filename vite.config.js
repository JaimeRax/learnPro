import { defineConfig } from "vite"
import laravel from "laravel-vite-plugin"

export default defineConfig({
  server: {
    port: 5173,
    hmr: {
      host: "localhost",
    },
  },
  plugins: [
    laravel({
      input: [
        // javascript
        "resources/js/laws/compliance_chart.js",
        "resources/js/articles/validate.js",
        "resources/sass/app.scss",
        // stylesheets
        "resources/sass/app.scss",
      ],
      refresh: true,
    }),
  ],
})
