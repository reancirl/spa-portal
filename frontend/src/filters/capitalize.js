import Vue from "vue";

Vue.filter("capitalize", function (value) {
  if (!value) {
    return "";
  }

  value = value.toString().split("_");

  for (let i = 0; i < value.length; i++) {
    value[i] = value[i].charAt(0).toUpperCase() + value[i].substring(1);
  }

  return value.join(" ");
});
