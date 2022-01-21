import Vue from 'vue';
import Vuex from 'vuex';

import Root from '../features/Store/Root';

Vue.use(Vuex);

const modules = {
  Root
};

const store = new Vuex.Store({
  modules
});

export default store;
