<script lang="ts">
  import { Component, Vue } from 'vue-property-decorator';
  import { mapState } from 'vuex';
  import ClickOutside from 'v-click-outside';

  @Component({
    directives: {
      ClickOutside: ClickOutside.directive,
    },
    computed: {
      ...mapState('Root', [
        'backUrl',
        'csrfToken',
        'menu',
        'activeClasses',
        'project',
      ]),
    }
  })
  export default class UserBar extends Vue {
    menuOpened: boolean = false;
    get path(): string {
      return this.$route.path;
    }

    logout() {
      this.$auth.logout({
        makeRequest: true,
        redirect: { name: 'auth.login' },
      });
    }

    toggleProfileDropdown(){
      this.menuOpened = !this.menuOpened;
    }

    closeSubMenu(){
      this.menuOpened = false;
    }
  }
</script>
<template>
    <div class="kt-header__topbar-item kt-header__topbar-item--user nav-link dropdown-toggle "
         v-click-outside="closeSubMenu">
        <div class="kt-header__topbar-wrapper  "
             @click="toggleProfileDropdown">
          <div class="kt-header__topbar-user">
            <span class="kt-header__topbar-welcome kt-hidden-mobile">Hi, </span>
            <span class="kt-header__topbar-username kt-hidden-mobile">{{$auth.user().first_name}}</span>
            <img class="kt-hidden" alt="Pic" src="" />

            <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
            <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold">
             <i class="fa fa-user-circle-o" aria-hidden="true"></i>
            </span>
          </div>
        </div>

        <div :class="['dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl', {
          'dropdown-menu':!menuOpened,}]">
        <!-- <div :class="['dropdown-menu-fit dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl ']" 
        v-if="menuOpened"> -->

          <!--begin: Head -->
          <!-- <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background-image: url(./assets/media/misc/bg-1.jpg)">
            <div class="kt-user-card__avatar">
            </div>
            <div class="kt-user-card__name">
            </div>
            <div class="kt-user-card__badge">
            </div>
          </div> -->

          <!--end: Head -->
          
          <!--begin: Navigation -->
          <div class="kt-notification user-bar-dropdown"> <!--dropdown-item-->
            <router-link :to="{ name: `myprofile` }"
                         class="kt-notification__item">
              <!-- <div class="kt-notification__item-icon">
                <i class="flaticon2-calendar-3 kt-font-success"></i>
              </div> -->
              <div class="kt-notification__item-details">
                <div class="kt-notification__item-title kt-font-bold">
                  My Profile
                </div>
                <div class="kt-notification__item-time">
                  Account settings and more
                </div>
              </div>
            </router-link>
            <div class="user-bar-signout kt-notification__custom kt-space-between">
              <a href="#"
                 @click.prevent="logout"
                 class="btn btn-label btn-label-brand btn-sm btn-bold">Sign Out</a>
            </div>
          </div>
          <hr>
          <!--end: Navigation -->
        </div>
    </div>

</template>

