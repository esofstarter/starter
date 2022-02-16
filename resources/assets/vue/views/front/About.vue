<script lang="ts">
import BasePage from "@/views/front/BasePage.vue";
import {Component} from 'vue-property-decorator';
import Team from '@/components/Starter/Pages/Team.vue';
import {Hooper, Slide, Navigation as HooperNavigation, Pagination as HooperPagination} from 'hooper';
import 'hooper/dist/hooper.css';
//Starter Comp

@Component({
  components: {
    Hooper,
    Slide,
    HooperNavigation,
    HooperPagination,
    Team,
  },
})
export default class About extends BasePage {
  loaded: boolean;
  hooperSettings: object;

  constructor() {
    super();
    this.loaded = false;
    this.hooperSettings = {
      itemsToShow: 1,
      itemsToSlide: 1,
      infiniteScroll: true,
      autoPlay: true,
      playSpeed: 5000,
      wheelControl: false,
      breakpoints: {
        1499: {
          itemsToShow: 1,
          itemsToSlide: 1,
        },
        959: {
          itemsToShow: 1,
          itemsToSlide: 1,
        },
        599: {
          itemsToShow: 1,
          itemsToSlide: 1,
        }
      }
    };
  }

  async mounted() {
  }
}
</script>

<template>
  <div class="about-us-page col-md-6">

    <Team/>
    <div class="about__text">
      <h4>At Starter, we believe there is a possible way out of every impossible situation. We're a group of
        developers
        and creative people dedicated to pushing the limits of what's possible by helping brands in achieving their
        goals.Our experience working with global brands allows us to fuel creative innovation that produces concrete
        benefits.
      </h4>
    </div>
  </div>
</template>

