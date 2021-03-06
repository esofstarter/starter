import Vue from 'vue';
import vuexI18n from 'vuex-i18n';

import store from '@/store';

import Locales from '@/vue-i18n-locales.generated';

Vue.use(vuexI18n.plugin, store);

Vue.i18n.add('en', Locales.en);
Vue.i18n.add('mk', Locales.mk);

const htmlTag = document.documentElement;
let lang = 'mk';

if (htmlTag) {
  lang = htmlTag.lang;
}

Vue.i18n.set(lang);
