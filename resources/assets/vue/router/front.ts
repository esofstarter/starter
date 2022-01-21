import Vue from 'vue';
import {RouteConfig, Location} from 'vue-router';
import About from "@/views/front/About.vue";
import DefaultPage from "@/views/layouts/front/DefaultPage.vue";
import Tech from "@/views/front/Tech.vue";
import Value from "@/views/front/Value.vue";
// import CreateBag from "@/views/front/CreateBag.vue";

// Not used
const PageNotFound = () => import(/* webpackChunkName: "PageNotFound" */ '../views/layouts/errors/PageNotFound.vue');

// Non authenticated user routes
const GuestDefaultPage = () => import(/* webpackChunkName: "GuestDefaultPage" */ '../views/layouts/front/GuestDefaultPage.vue');
const DefaultPage = () => import (/* webpackChunkName: "GuestDefaultPage" */ '../views/layouts/front/DefaultPage.vue');

export let frontRouteConfig: RouteConfig =
  {
    path: '/',
    component: GuestDefaultPage,
    meta: {
      title: Vue.i18n.translate('strings.home', null)
    },
    children: [
      {
        path: '/',
        component: DefaultPage,
        meta: {
          title: Vue.i18n.translate('strings.home', null)
        }
      },
      {
        path: '/tech',
        component: Tech,
        meta: {
          title: Vue.i18n.translate('strings.home', null)
        }
      },
      {
        path: '/about',
        component: About,
        meta: {
          title: Vue.i18n.translate('strings.home', null)
        }
      },
      {
        path: '/value',
        component: Value,
        meta: {
          title: Vue.i18n.translate('strings.home', null)
        }
      }

    ]
  };
