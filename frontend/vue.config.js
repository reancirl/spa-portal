const path = require("path");
const jsonImporter = require("node-sass-json-importer");
const Theme = require("./theme.json");

module.exports = {
  devServer: {
    port: 8000,
  },

  lintOnSave: false,

  transpileDependencies: ["vuetify"],

  pluginOptions: {
    lintStyleOnBuild: true,
    stylelint: {},
  },

  configureWebpack: {
    resolve: {
      extensions: [".js", ".json", ".vue"],
      alias: {
        "@utils": path.resolve(__dirname, "./src/utilities"),
        "theme.json": path.resolve(__dirname, "./theme.json"),
      },
    },

    module: {
      rules: [
        {
          test: /\.(sc|c|sa)ss$/,
          loader: "import-glob-loader",
        },
      ],
    },
  },

  css: {
    loaderOptions: {
      sass: {
        sassOptions: {
          importer: jsonImporter(),
          data: `
            @import "@/sass/variables.scss";
          `,
        },
      },
    },
  },
};
