<script lang="ts">
  import {Component, Emit, Prop, Vue, Watch} from 'vue-property-decorator';
  import { namespace } from 'vuex-class';
  import { mapState } from 'vuex';

  /*Partials*/
  import BrandComponent from '@/features/Admin/_partials/Brand.vue';
  import FirstLevelMenuItem from '@/features/Admin/_partials/FirstLevelMenuItem.vue';
  import AdminSidebarState from '@/typings/Admin/sidebar.d.ts'

  const { Action } = namespace('Root');
  const { State } = namespace('Root');

  @Component({
    components: {
      BrandComponent,
      FirstLevelMenuItem,
    },
    computed: {
      ...mapState('Root', [
          'activeClasses',
      ]),
    },
  })

  export default class AdminSidebar extends Vue {
    @Prop() item: any;
    @Action('setMenu') setMenu;
    @State('homeItems') homeItems;

    sidebarState: AdminSidebarState;
    clearMinimizingTimeout: any = '';


    constructor() {
      super();
      this.sidebarState = {
        minimized: false,
        minimizeHover: false,
        minimizing: false,
      };
    }

    setMinimizing() {
      clearTimeout(this.clearMinimizingTimeout);
      this.sidebarState.minimizing = true;
      this.clearMinimizingTimeout = setTimeout(()=>{
        this.sidebarHover(('minimizingOff'));
      },300);
    }

    // TODO: avoid interfering the hover when minimizing is triggered
    @Emit('sidebar-hover')
    sidebarHover(string: string = '') {

      if (this.sidebarState.minimized) {
        if (string === 'over' ) {
          this.sidebarState.minimizeHover = true;
          this.setMinimizing();
        }
        if (string === 'leave') {
          this.sidebarState.minimizeHover = false;
          this.setMinimizing();
        }
      }

      if (string === 'toggleSidebar'){
        this.sidebarState.minimized = !this.sidebarState.minimized;
        if (!this.sidebarState.minimized) {
          this.sidebarState.minimizeHover = false;
        }
        this.setMinimizing();
      }

      if (string === 'minimizingOff') {
        this.sidebarState.minimizing = false;
      }
      return this.sidebarState;

    }

    mounted() {
        this.setMenu([]);
        this.sidebarHover();
    }
  }
</script>

<template>

  <!-- begin:: Aside -->
  <!--<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>-->
  <div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop"
       id="kt_aside"
       @mouseover="sidebarHover('over')"
       @mouseleave="sidebarHover('leave')">

    <brand-component @toggle-sidebar="sidebarHover('toggleSidebar')"></brand-component>

    <!-- begin:: Aside Menu -->
    <div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
      <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
        <ul class="kt-menu__nav ">

          <first-level-menu-item
            v-if="$auth.user().permissions_array.includes(item.permission)"
            v-for='(item,key) in homeItems'
            :item="item"
            :key="key"
          ></first-level-menu-item>

        </ul>
      </div>
    </div>
    <!-- end:: Aside Menu -->

  </div>
  <!-- end:: Aside -->
</template>
