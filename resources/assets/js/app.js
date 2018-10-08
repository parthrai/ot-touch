
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require( 'jquery' );

window.Vue = require('vue');

import Vuetify from 'vuetify'

import VueRouter from 'vue-router'
import routes from './routes'
import IdleVue from 'idle-vue'


const eventsHub = new Vue()


Vue.use(IdleVue, {
    eventEmitter: eventsHub,
    idleTime: 30000 // the amount of time (ms) before user is considered idle
})


Vue.use(Vuetify);

/** Vue Router for Touch Screens **/

Vue.use(VueRouter);
const router = new VueRouter({
    routes
});

/** Vue Router for Touch Screens **/


/** BEGIN: Useful Functions ------------------------------------------------ **/

window.NumberWithCommas = function ( num )
{
  return( num.toString().replace( /\B(?=(\d{3})+(?!\d))/g, "," ) );
}

/** END: Useful Functions -------------------------------------------------- **/

/** BEGIN: QR Code Generator ----------------------------------------------- **/

import VueQrcode from '@xkeshi/vue-qrcode';
Vue.component( VueQrcode.name, VueQrcode );

Vue.component(
  'GenerateQrCode',
  require( './components/QR-CODES/GenerateQrCode.vue' )
);

/** END: QR Code Generator ------------------------------------------------- **/

/** BEGIN: Social Wall ----------------------------------------------------- **/

import VueMasonry from 'vue-masonry-css';
Vue.use( VueMasonry );

Vue.component(
  'FinalCountdown',
  require( './components/social-wall/FinalCountdown.vue' )
);

Vue.component(
  'LogoScreen',
  require( './components/social-wall/LogoScreen.vue' )
);

Vue.component(
  'AnnouncementScreen',
  require( './components/social-wall/AnnouncementScreen.vue' )
);

Vue.component(
  'LeaderboardScreen',
  require( './components/social-wall/LeaderboardScreen.vue' )
);

Vue.component(
  'TeamBadge',
  require( './components/social-wall/TeamBadge.vue' )
);

Vue.component(
  'ScoreboardTeams',
  require( './components/social-wall/ScoreboardTeams.vue' )
);

Vue.component(
  'ScoreboardTeamMembers',
  require( './components/social-wall/ScoreboardTeamMembers.vue' )
);

Vue.component(
  'SocialCards',
  require( './components/social-wall/SocialCards.vue' )
);

/** END: Social Wall ------------------------------------------------------- **/

/** BEGIN: Modal Dialogues ------------------------------------------------- **/

Vue.component(
  'ModalConfirmHrefAction',
  require( './components/dialogue-boxes/ModalConfirmHrefAction.vue' )
);

/** END: Modal Dialogues --------------------------------------------------- **/


/** Touch Screens **/


 Vue.component('nav-tiles',require('./components/TouchScreen/Nav/tiles.vue'));
 Vue.component('nav-drawer',require('./components/TouchScreen/drawer/Drawer.vue'));
 Vue.component('touchscreen',require('./components/TouchScreen/TouchScreen.vue'));

 Vue.component('agenda',require('./components/TouchScreen/Agenda/Agenda.vue'));
 Vue.component('ew-games',require('./components/TouchScreen/EWGames/EWGames.vue'));
 Vue.component('home',require('./components/TouchScreen/Home/Home.vue'));
 Vue.component('expo',require('./components/TouchScreen/Expo/Expo.vue'));
 Vue.component('events',require('./components/TouchScreen/Events/Event.vue'));

 /** End Touch Screens **/


/** BEGIN: Bind Vue to Application ----------------------------------------- **/

const app = new Vue(
  {
    el: '#app',
      router

  }
);

/** END: Bind Vue to Application ------------------------------------------- **/
