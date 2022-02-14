<script lang="ts">
  import {Component, Vue, Watch} from 'vue-property-decorator';
    import { namespace } from 'vuex-class';

    import AdminHeader from '@/views/layouts/admin/AdminHeader.vue';
    import AdminSidebar from '@/views/layouts/admin/AdminSidebar.vue';
    import AdminFooter from '@/views/layouts/admin/AdminFooter.vue';

    const { Action } = namespace('Root');
    const { State } = namespace('Root');

    @Component({
        components: {
            AdminHeader,
            AdminSidebar,
            AdminFooter
        },
        // watch: {
        //   '$route' (to, from) {
        //     EventBus.$emit('routeChanged');
        //   }
        // }
    })
    export default class AdminDefaultPage extends Vue {
      @Action('setMenu') setMenu;
      // @Action('setAdminPageHeader') setAdminPageHeader;
      @State('homeItems') homeItems;

      sidebarState: object = {};

      @Watch('$route')
      onRouteChange(val: string, oldVal: string) {
        // this.setAdminPageHeader(this.$router.currentRoute.meta.title);
      }

      mounted() {
        this.setMenu([]);
        // this.setAdminPageHeader(this.$router.currentRoute.meta.title);
      }

      created () {
        var root = document.getElementsByTagName( 'html' )[0];
        root.classList.add("admin-view");
      }

      destroyed () {
        var root = document.getElementsByTagName( 'html' )[0];
        root.classList.remove("admin-view");
      }

      sidebarClass(sidebarState: object): void {
        this.sidebarState = sidebarState;
      }
    }
</script>

<template>
  <div  class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed"
        :class="({
          'kt-aside--minimize' : sidebarState.minimized && !sidebarState.minimizeHover,
          'kt-aside--minimize-hover' : sidebarState.minimizeHover,
          'kt-aside--minimizing' : sidebarState.minimizing,
        })">

    <!-- begin:: Header Mobile -->
    <div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
      <div class="kt-header-mobile__logo">
        <a href="">
          <img alt="Logo" src="" />
        </a>
      </div>
      <div class="kt-header-mobile__toolbar">
        <button class="kt-header-mobile__toggler kt-header-mobile__toggler--left" id="kt_aside_mobile_toggler"><span></span></button>
        <button class="kt-header-mobile__toggler" id="kt_header_mobile_toggler"><span></span></button>
        <button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></button>
      </div>
    </div>
    <!-- end:: Header Mobile -->

    <div class="kt-grid kt-grid--hor kt-grid--root">
      <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

        <admin-sidebar @sidebar-hover="sidebarClass"/>

        <admin-header/>

        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="F">
          <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">

            <router-view :key="$route.fullPath"/>

          </div>
        </div>

      </div>
    </div>

    <dialogs-wrapper wrapper-name="default" />

  </div>
</template>
