<template>
  <div class="social-cards-container">

    <masonry
      :cols=" columns "
      :gutter="10"
    >

      <!-- BEGIN: Social Cards List **************************************** -->
      <div
        v-for=" card in cards "
        :key="card.card_vue_id"
      >

        <transition
          name="social-card"
          appear
        >

          <section class="social-card">

            <!-- BEGIN: Social Cards Contents ****************************** -->
            <article :class=" 'social-card-body ' + card.css_class ">

              <!-- BEGIN: Tweet ******************************************** -->
              <div v-if=" card.card_type === 'tweet' ">
                <div
                  v-if=" card.user_screen_name "
                  class="social-card-user-name"
                >
                  @{{ card.user_screen_name }}
                </div>
                <div>
                  <div v-if=" card.image ">
                    <div class="social-card-text">{{ card.tweet_text }}</div>
                    <div>
                      <transition
                        appear
                        appear-class="social-card-image-appear"
                        appear-to-class="social-card-image"
                        appear-active-class="social-card-image"
                      >
                        <img
                          class="img-responsive social-card-image"
                          v-bind:src=" card.image "
                        >
                      </transition>
                    </div>
                  </div>
                  <div v-else>
                    <span
                      v-if=" card.user_image "
                      class="social-card-avatar"
                    >
                      <img v-bind:src=" card.user_image ">
                    </span>
                    <div class="social-card-text">{{ card.tweet_text }}</div>
                  </div>
                </div>
              </div>
              <!-- BEGIN: Tweet ******************************************** -->

              <!-- BEGIN: AppWorks Post ************************************ -->
              <div v-if=" card.card_type === 'appworks_post' ">
                <div>
                  <span
                    v-if=" card.first_name "
                    class="social-card-user-name"
                  >
                    @{{ card.first_name }}
                  </span>
                  <span
                    v-if=" card.last_name "
                    class="social-card-user-name"
                  >
                    @{{ card.last_name }}
                  </span>
                  <span
                    v-if=" card.title "
                    class="social-card-user-title"
                  >
                    - @{{ card.title }}
                  </span>
                </div>
                <div
                  v-if=" card.company "
                  class="social-card-company"
                >
                  {{ card.company }}
                </div>
                <div>
                  <div v-if=" card.image ">
                    <div class="social-card-text">{{ card.post_text }}</div>
                    <div>
                      <transition
                        appear
                        appear-class="social-card-image-appear"
                        appear-to-class="social-card-image"
                        appear-active-class="social-card-image"
                      >
                        <img
                          class="img-responsive social-card-image"
                          v-bind:src=" card.image "
                        >
                      </transition>
                    </div>
                  </div>
                  <div v-else>
                    <span
                      v-if=" card.profile_photo "
                      class="social-card-avatar"
                    >
                      <img v-bind:src=" card.profile_photo ">
                    </span>
                    <div class="social-card-text">{{ card.post_text }}</div>
                  </div>
                </div>
              </div>
              <!-- END: AppWorks Post ************************************** -->

            </article>
            <!-- END: Social Cards Contents ******************************** -->

          </section>

        </transition>

      </div>
      <!-- END: Social Cards List ****************************************** -->

    </masonry>

  </div>
</template>

<script>
  export default
  {
    /** -------------------------------------------------------------------- **/
    props: [
      'maxItems',
      'scheduleFrequencyMs'
    ],
    /** -------------------------------------------------------------------- **/
    data: function ()
    {
      return(
        {
          cards: [], // Set of cards to display
          seen: [],  // History of seen cards
          columns: { // Masonry columns
            default: 8,
            400: 3,
            800: 4,
            1024: 6,
            1280: 8,
            1920: 8,
            3840: 16,
            4096: 18,
            7680: 30
          }
        }
      );
    },
    /** -------------------------------------------------------------------- **/
    watch:
    {
      columns: function ()
      {
        let vueInstance = this;
        console.log( "forceUpdate" );
        vueInstance.$forceUpdate();
      }
    },
    /** -------------------------------------------------------------------- **/
    methods: {
      /** ------------------------------------------------------------------ **/
      getCards: function ()
      {

        let vueInstance = this;
        
        axios.get(
          '/api/social-cards/get-cards',
          {
            params: {
              max_items: vueInstance.maxItems
            }
          }
        )
        .then(
          function ( response )
          {
        
            for( let card of response.data )
            {
            
              switch( card.card_type )
              {
                case 'appworks_post' :
                  card.css_class = 'social-card-appworks-post';
                  break;
                case 'tweet' :
                  card.css_class = 'social-card-twitter';
                  break;
                default:
                  card.css_class = '';
              }
              
              if( ! ( card.card_vue_id in vueInstance.seen ) )
              {
                vueInstance.seen[card.card_vue_id] = true;
                if( vueInstance.cards.length > vueInstance.maxItems )
                {
                  vueInstance.cards.pop();
                }
                vueInstance.cards.unshift( card );
              }

            }

          }
        )
        .catch(
          function ( error )
          {
            console.log( error );
          }
        )
        .then(
          function ()
          {
            vueInstance.scheduleFetch();
          }
        );
      },
      /** ------------------------------------------------------------------ **/
      scheduleFetch: function ()
      {
        let vueInstance = this;
        setTimeout(
          function ()
          {
            vueInstance.getCards();
          },
          vueInstance.scheduleFrequencyMs
        );
      },
      /** ------------------------------------------------------------------ **/
    },
    /** -------------------------------------------------------------------- **/
    created: function ()
    {
      let vueInstance = this;
    },
    /** -------------------------------------------------------------------- **/
    mounted: function ()
    {
      let vueInstance = this;
      vueInstance.getCards();
    },
    /** -------------------------------------------------------------------- **/
    beforeDestroy: function ()
    {
      let vueInstance = this;
    }
    /** -------------------------------------------------------------------- **/
  }
</script>

<style lang="scss" scoped>

  @import '~@/_opentext_branding.scss';

  .social-cards-container
  {
    width:100%;

    .social-card,
    {
      margin-top:0px;
      margin-bottom:1vh;
      &-enter-active,
      &-leave-active
        {
        transition-property:opacity transform;
        transition-duration:1.0s;
        transition-timing-function:ease;
      }
      &-enter-active
      {
        transition-delay:100ms;
      }
      &-enter,
      &-leave-to
      {
        opacity:0;
        transform:scale( 0.5, 0.5 );
      }
      &-leave,
      &-enter-to
      {
        opacity:1;
        transform:scale( 1.0, 1.0 );
      }
      &-move
      {
        transition-property:all;
        transition-duration:1.0s;
        transition-timing-function:ease;
      }
    }

    .social-card-body
    {
      font-size:12pt;
      line-height:15pt;
      border-style:solid;
      border-width:6px 0px 0px 0px;
      border-color:$ot_blue;
      border-radius:0% 0% 2% 2%;
      background-color:rgba(255,255,255,0.8);
      box-shadow: 0px 0px 10px rgba(64,64,255,0.4);
    }

    .social-card-twitter
    {
      border-color:$ot_blue;
      background-image:url('/images/social-media-logos/Twitter_Logo_Blue_Trans.png');
      background-position: bottom 0vw right 0vw;
      background-size:4vw;
      background-repeat:no-repeat;
    }

    .social-card-appworks-post
    {
      border-color:$ot_black;
    }

    .social-card-body > div
    {
      padding:1vh 0.5vw 1vh 0.5vw;
      overflow:hidden;
      .social-card-avatar
      {
        float:right;
        margin-left:1vw;
        margin-right:0vw;
        img
        {
          width:2vw;
        }
      }
      .social-card-image
      {
        margin-bottom: 0.1vw;
        border-radius:0% 0% 3% 3%;
        opacity:1;
        transition-property:opacity;
        transition-duration:1.0s;
        transition-timing-function:ease-in-out;
        .social-card-image-appear
        {
          opacity:0;
        }
      }
      .social-card-user-name
      {
        color:$ot_black;
        font-weight:bold;
        margin-top:0.5vw;
      }
      .social-card-user-title
      {
        font-style:italic;
      }
      .social-card-company
      {
        color:$ot_blue;
        font-weight:bold;
      }
      .social-card-text
      {
        margin-top:0.5vw;
        margin-bottom:0.5vw;
      }
    }
  
  }

</style>
