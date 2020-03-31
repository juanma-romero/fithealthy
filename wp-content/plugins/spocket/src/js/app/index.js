import Vue from 'vue';
import App from './App.vue';

const APP = '.js-spocket-admin-interface';

export default function init () {
  const appEl = document.querySelector (APP);

  if (!appEl) {
    return;
  }

  // eslint-disable-next-line no-new
  new Vue ({
    el: appEl,
    render: h => h (App),
  });
}
