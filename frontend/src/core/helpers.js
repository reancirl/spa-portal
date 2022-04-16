import moment from "moment";

export function basename(str, sep) {
  return str.substr(str.lastIndexOf(sep) + 1);
}

export function strip_extension(str) {
  return str.substr(0, str.lastIndexOf("."));
}

export function format_price(price) {
  const amount = price ? parseFloat(price) : 0;
  return amount.toLocaleString('en-US', { style: 'currency', currency: 'PHP' })
}

export function format_date(date) {
  return moment(date).format('D MMMM YYYY @ h:mm a');
}